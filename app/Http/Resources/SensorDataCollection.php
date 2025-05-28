<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class SensorDataCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'data' => SensorDataResource::collection($this->collection),
            'meta' => [
                'total_readings' => $this->collection->count(),
                'date_range' => [
                    'from' => $this->collection->min('recorded_at'),
                    'to' => $this->collection->max('recorded_at'),
                ],
                'average_moisture' => $this->collection->avg('soil_moisture'),
                'average_temperature' => $this->collection->avg('temperature'),
                'average_humidity' => $this->collection->avg('humidity'),
            ]
        ];
    }
}
