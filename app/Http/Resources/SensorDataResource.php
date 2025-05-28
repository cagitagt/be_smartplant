<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SensorDataResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'plant_id' => $this->plant_id,
            'device_id' => $this->device_id,
            'soil_moisture' => $this->soil_moisture, // percentage
            'temperature' => $this->temperature, // celsius
            'humidity' => $this->humidity, // percentage
            'light_intensity' => $this->light_intensity, // lux
            'ph_level' => $this->ph_level,
            'water_level' => $this->water_level, // in tank/reservoir
            'recorded_at' => $this->recorded_at,
            'created_at' => $this->created_at,

            // Relationships
            'plant' => new PlantResource($this->whenLoaded('plant')),
            'device' => new DeviceResource($this->whenLoaded('device')),

            // Status indicators
            'moisture_status' => $this->when(isset($this->moisture_status), $this->moisture_status), // low, normal, high
            'temperature_status' => $this->when(isset($this->temperature_status), $this->temperature_status),
            'needs_attention' => $this->when(isset($this->needs_attention), $this->needs_attention),
        ];
    }
}
