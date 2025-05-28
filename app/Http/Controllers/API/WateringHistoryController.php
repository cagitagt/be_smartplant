<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\WateringHistory\StoreWateringHistoryRequest;
use App\Http\Resources\WateringHistoryResource;
use App\Models\Plant;
use App\Models\WateringHistory;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class WateringHistoryController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request, Plant $plant): JsonResponse
    {
        $this->authorize('view', $plant);

        $history = $plant->wateringHistory()
            ->when($request->date_from, function ($query, $dateFrom) {
                return $query->where('watered_at', '>=', $dateFrom);
            })
            ->when($request->date_to, function ($query, $dateTo) {
                return $query->where('watered_at', '<=', $dateTo);
            })
            ->when($request->method, function ($query, $method) {
                return $query->where('method', $method);
            })
            ->orderBy('watered_at', 'desc')
            ->paginate(15);

        return response()->json([
            'success' => true,
            'data' => WateringHistoryResource::collection($history),
            'meta' => [
                'current_page' => $history->currentPage(),
                'last_page' => $history->lastPage(),
                'per_page' => $history->perPage(),
                'total' => $history->total(),
            ]
        ]);
    }

    public function store(StoreWateringHistoryRequest $request, Plant $plant): JsonResponse
    {
        $this->authorize('update', $plant);

        $wateringHistory = $plant->wateringHistory()->create($request->validated());

        $plant->notifications()->create([
            'type' => 'watering_completed',
            'title' => 'Plant Watered',
            'message' => "Plant watered for {$wateringHistory->duration_minutes} minutes using {$wateringHistory->method}",
            'priority' => 'low',
            'data' => ['watering_history_id' => $wateringHistory->id]
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Watering history recorded successfully',
            'data' => new WateringHistoryResource($wateringHistory)
        ], 201);
    }

    public function show(Plant $plant, WateringHistory $wateringHistory): JsonResponse
    {
        $this->authorize('view', $plant);

        if ($wateringHistory->plant_id !== $plant->id) {
            return response()->json([
                'success' => false,
                'message' => 'Watering history not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => new WateringHistoryResource($wateringHistory)
        ]);
    }

    public function destroy(Plant $plant, WateringHistory $wateringHistory): JsonResponse
    {
        $this->authorize('update', $plant);

        if ($wateringHistory->plant_id !== $plant->id) {
            return response()->json([
                'success' => false,
                'message' => 'Watering history not found'
            ], 404);
        }

        $wateringHistory->delete();

        return response()->json([
            'success' => true,
            'message' => 'Watering history deleted successfully'
        ]);
    }

    public function statistics(Request $request, Plant $plant): JsonResponse
    {
        $this->authorize('view', $plant);

        $period = $request->input('period', '30');
        $startDate = Carbon::now()->subDays($period);

        $stats = [
            'total_waterings' => $plant->wateringHistory()
                ->where('watered_at', '>=', $startDate)
                ->count(),

            'total_water_amount' => $plant->wateringHistory()
                ->where('watered_at', '>=', $startDate)
                ->sum('water_amount_ml'),

            'total_duration' => $plant->wateringHistory()
                ->where('watered_at', '>=', $startDate)
                ->sum('duration_minutes'),

            'average_per_watering' => $plant->wateringHistory()
                ->where('watered_at', '>=', $startDate)
                ->avg('water_amount_ml'),

            'methods_breakdown' => $plant->wateringHistory()
                ->where('watered_at', '>=', $startDate)
                ->selectRaw('method, COUNT(*) as count')
                ->groupBy('method')
                ->pluck('count', 'method'),

            'last_watered' => $plant->wateringHistory()
                ->latest('watered_at')
                ->first()
                ?->watered_at,
        ];

        return response()->json([
            'success' => true,
            'data' => $stats,
            'period_days' => $period
        ]);
    }
}
