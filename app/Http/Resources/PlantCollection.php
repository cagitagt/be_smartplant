<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class PlantCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'data' => PlantResource::collection($this->collection),
            'meta' => [
                'total_plants' => $this->collection->count(),
                'active_plants' => $this->collection->where('status', 'active')->count(),
                'plants_needing_water' => $this->when(isset($this->plants_needing_water), $this->plants_needing_water),
            ]
        ];
    }
}
