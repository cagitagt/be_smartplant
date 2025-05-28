<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Device\StoreDeviceRequest;
use App\Http\Requests\Device\UpdateDeviceRequest;
use App\Http\Resources\DeviceResource;
use App\Models\Device;
use App\Models\Plant;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DeviceController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request, Plant $plant): JsonResponse
    {
        $this->authorize('view', $plant);

        $devices = $plant->devices()
            ->when($request->type, function ($query, $type) {
                return $query->where('device_type', $type);
            })
            ->when($request->status, function ($query, $status) {
                return $query->where('status', $status);
            })
            ->orderBy('device_name')
            ->paginate(10);

        return response()->json([
            'success' => true,
            'data' => DeviceResource::collection($devices),
            'meta' => [
                'current_page' => $devices->currentPage(),
                'last_page' => $devices->lastPage(),
                'per_page' => $devices->perPage(),
                'total' => $devices->total(),
            ]
        ]);
    }

    public function store(StoreDeviceRequest $request, Plant $plant): JsonResponse
    {
        $this->authorize('update', $plant);

        $device = $plant->devices()->create($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Device registered successfully',
            'data' => new DeviceResource($device)
        ], 201);
    }

    public function show(Plant $plant, Device $device): JsonResponse
    {
        $this->authorize('view', $plant);

        if ($device->plant_id !== $plant->id) {
            return response()->json([
                'success' => false,
                'message' => 'Device not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => new DeviceResource($device)
        ]);
    }

    public function update(UpdateDeviceRequest $request, Plant $plant, Device $device): JsonResponse
    {
        $this->authorize('update', $plant);

        if ($device->plant_id !== $plant->id) {
            return response()->json([
                'success' => false,
                'message' => 'Device not found'
            ], 404);
        }

        $device->update($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Device updated successfully',
            'data' => new DeviceResource($device)
        ]);
    }

    public function destroy(Plant $plant, Device $device): JsonResponse
    {
        $this->authorize('update', $plant);

        if ($device->plant_id !== $plant->id) {
            return response()->json([
                'success' => false,
                'message' => 'Device not found'
            ], 404);
        }

        $device->delete();

        return response()->json([
            'success' => true,
            'message' => 'Device removed successfully'
        ]);
    }

    public function updateStatus(Request $request, Plant $plant, Device $device): JsonResponse
    {
        $this->authorize('update', $plant);

        if ($device->plant_id !== $plant->id) {
            return response()->json([
                'success' => false,
                'message' => 'Device not found'
            ], 404);
        }

        $request->validate([
            'status' => 'required|in:online,offline,maintenance,error',
            'battery_level' => 'nullable|integer|min:0|max:100',
            'last_connected' => 'nullable|date',
        ]);

        $device->update([
            'status' => $request->status,
            'battery_level' => $request->battery_level ?? $device->battery_level,
            'last_connected' => $request->last_connected ?? now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Device status updated',
            'data' => new DeviceResource($device)
        ]);
    }
}
