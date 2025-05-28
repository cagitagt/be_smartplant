<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DeviceResource extends JsonResource
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
            'device_name' => $this->device_name,
            'device_type' => $this->device_type, // sensor, pump, valve, etc.
            'device_id' => $this->device_id, // unique hardware ID
            'mac_address' => $this->mac_address,
            'ip_address' => $this->ip_address,
            'status' => $this->status, // online, offline, maintenance
            'battery_level' => $this->battery_level,
            'firmware_version' => $this->firmware_version,
            'last_seen' => $this->last_seen,
            'location' => $this->location,
            'is_active' => $this->is_active,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

            // Relationships
            'plant' => new PlantResource($this->whenLoaded('plant')),
            'sensor_data' => SensorDataResource::collection($this->whenLoaded('sensorData')),

            // Device capabilities
            'capabilities' => $this->when(isset($this->capabilities), $this->capabilities), // JSON array
            'settings' => $this->when(isset($this->settings), $this->settings), // JSON object
        ];
    }
}
