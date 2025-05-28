<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\SensorData\StoreSensorDataRequest;
use App\Http\Resources\SensorDataResource;
use App\Models\Plant;
use App\Models\SensorData;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SensorDataController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request, Plant $plant): JsonResponse
    {
        $this->authorize('view', $plant);

        $sensorData = $plant->sensorData()
            ->when($request->date_from, function ($query, $dateFrom) {
                return $query->where('recorded_at', '>=', $dateFrom);
            })
            ->when($request->date_to, function ($query, $dateTo) {
                return $query->where('recorded_at', '<=', $dateTo);
            })
            ->orderBy('recorded_at', 'desc')
            ->paginate(20);

        return response()->json([
            'success' => true,
            'data' => SensorDataResource::collection($sensorData),
            'meta' => [
                'current_page' => $sensorData->currentPage(),
                'last_page' => $sensorData->lastPage(),
                'per_page' => $sensorData->perPage(),
                'total' => $sensorData->total(),
            ]
        ]);
    }

    public function store(StoreSensorDataRequest $request, Plant $plant): JsonResponse
    {
        $this->authorize('update', $plant);

        $sensorData = $plant->sensorData()->create($request->validated());

        $this->checkSensorThresholds($plant, $sensorData);

        return response()->json([
            'success' => true,
            'message' => 'Sensor data recorded successfully',
            'data' => new SensorDataResource($sensorData)
        ], 201);
    }

    public function latest(Plant $plant): JsonResponse
    {
        $this->authorize('view', $plant);

        $latestData = $plant->sensorData()->latest()->first();

        if (!$latestData) {
            return response()->json([
                'success' => false,
                'message' => 'No sensor data found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => new SensorDataResource($latestData)
        ]);
    }

    private function checkSensorThresholds(Plant $plant, SensorData $sensorData): void
    {
        if ($sensorData->soil_moisture < $plant->optimal_moisture_min) {
            $plant->notifications()->create([
                'type' => 'low_moisture',
                'title' => 'Low Soil Moisture',
                'message' => "Soil moisture is {$sensorData->soil_moisture}%, below optimal range.",
                'priority' => 'high',
                'data' => ['sensor_data_id' => $sensorData->id]
            ]);
        }

        if ($sensorData->temperature > $plant->optimal_temperature_max) {
            $plant->notifications()->create([
                'type' => 'high_temperature',
                'title' => 'High Temperature Alert',
                'message' => "Temperature is {$sensorData->temperature}°C, above optimal range.",
                'priority' => 'medium',
                'data' => ['sensor_data_id' => $sensorData->id]
            ]);
        }
    }
}
