<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Plant\StorePlantRequest;
use App\Http\Requests\Plant\UpdatePlantRequest;
use App\Http\Resources\PlantResource;
use App\Models\Plant;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class PlantController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request): JsonResponse
    {
        $plants = $request->user()->plants()
            ->with(['sensorData' => function ($query) {
                $query->latest()->limit(1);
            }, 'devices', 'irrigationSchedules'])
            ->paginate(10);

        return response()->json([
            'success' => true,
            'data' => PlantResource::collection($plants),
            'meta' => [
                'current_page' => $plants->currentPage(),
                'last_page' => $plants->lastPage(),
                'per_page' => $plants->perPage(),
                'total' => $plants->total(),
            ]
        ]);
    }

    public function store(StorePlantRequest $request): JsonResponse
    {
        $plant = $request->user()->plants()->create($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Plant created successfully',
            'data' => new PlantResource($plant)
        ], 201);
    }

    public function show(Plant $plant): JsonResponse
    {
        $this->authorize('view', $plant);

        $plant->load(['sensorData', 'devices', 'irrigationSchedules', 'wateringHistory', 'notifications']);

        return response()->json([
            'success' => true,
            'data' => new PlantResource($plant)
        ]);
    }

    public function update(UpdatePlantRequest $request, Plant $plant): JsonResponse
    {
        $this->authorize('update', $plant);

        $plant->update($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Plant updated successfully',
            'data' => new PlantResource($plant)
        ]);
    }

    public function destroy(Plant $plant): JsonResponse
    {
        $this->authorize('delete', $plant);

        $plant->delete();

        return response()->json([
            'success' => true,
            'message' => 'Plant deleted successfully'
        ]);
    }
}
