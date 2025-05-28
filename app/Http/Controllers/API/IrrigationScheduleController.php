<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\IrrigationSchedule\StoreIrrigationScheduleRequest;
use App\Http\Requests\IrrigationSchedule\UpdateIrrigationScheduleRequest;
use App\Http\Resources\IrrigationScheduleResource;
use App\Models\IrrigationSchedule;
use App\Models\Plant;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class IrrigationScheduleController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request, Plant $plant): JsonResponse
    {
        $this->authorize('view', $plant);

        $schedules = $plant->irrigationSchedules()
            ->when($request->status, function ($query, $status) {
                return $query->where('is_active', $status === 'active');
            })
            ->orderBy('schedule_time')
            ->paginate(10);

        return response()->json([
            'success' => true,
            'data' => IrrigationScheduleResource::collection($schedules),
            'meta' => [
                'current_page' => $schedules->currentPage(),
                'last_page' => $schedules->lastPage(),
                'per_page' => $schedules->perPage(),
                'total' => $schedules->total(),
            ]
        ]);
    }

    public function store(StoreIrrigationScheduleRequest $request, Plant $plant): JsonResponse
    {
        $this->authorize('update', $plant);

        $schedule = $plant->irrigationSchedules()->create($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Irrigation schedule created successfully',
            'data' => new IrrigationScheduleResource($schedule)
        ], 201);
    }

    public function show(Plant $plant, IrrigationSchedule $irrigationSchedule): JsonResponse
    {
        $this->authorize('view', $plant);

        if ($irrigationSchedule->plant_id !== $plant->id) {
            return response()->json([
                'success' => false,
                'message' => 'Irrigation schedule not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => new IrrigationScheduleResource($irrigationSchedule)
        ]);
    }

    public function update(UpdateIrrigationScheduleRequest $request, Plant $plant, IrrigationSchedule $irrigationSchedule): JsonResponse
    {
        $this->authorize('update', $plant);

        if ($irrigationSchedule->plant_id !== $plant->id) {
            return response()->json([
                'success' => false,
                'message' => 'Irrigation schedule not found'
            ], 404);
        }

        $irrigationSchedule->update($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Irrigation schedule updated successfully',
            'data' => new IrrigationScheduleResource($irrigationSchedule)
        ]);
    }

    public function destroy(Plant $plant, IrrigationSchedule $irrigationSchedule): JsonResponse
    {
        $this->authorize('update', $plant);

        if ($irrigationSchedule->plant_id !== $plant->id) {
            return response()->json([
                'success' => false,
                'message' => 'Irrigation schedule not found'
            ], 404);
        }

        $irrigationSchedule->delete();

        return response()->json([
            'success' => true,
            'message' => 'Irrigation schedule deleted successfully'
        ]);
    }

    public function toggle(Plant $plant, IrrigationSchedule $irrigationSchedule): JsonResponse
    {
        $this->authorize('update', $plant);

        if ($irrigationSchedule->plant_id !== $plant->id) {
            return response()->json([
                'success' => false,
                'message' => 'Irrigation schedule not found'
            ], 404);
        }

        $irrigationSchedule->update([
            'is_active' => !$irrigationSchedule->is_active
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Irrigation schedule status updated',
            'data' => new IrrigationScheduleResource($irrigationSchedule)
        ]);
    }
}
