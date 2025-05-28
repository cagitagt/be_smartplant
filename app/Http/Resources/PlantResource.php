<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PlantResource extends JsonResource
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
            'user_id' => $this->user_id,
            'name' => $this->name,
            'type' => $this->type,
            'description' => $this->description,
            'location' => $this->location,
            'planting_date' => $this->planting_date,
            'status' => $this->status,
            'image_url' => $this->image_url,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

            // Relationships
            'irrigation_schedules' => IrrigationScheduleResource::collection($this->whenLoaded('irrigationSchedules')),
            'sensor_data' => SensorDataResource::collection($this->whenLoaded('sensorData')),
            'devices' => DeviceResource::collection($this->whenLoaded('devices')),
            'watering_history' => WateringHistoryResource::collection($this->whenLoaded('wateringHistory')),
            'notifications' => NotificationResource::collection($this->whenLoaded('notifications')),

            // Latest sensor data
            'latest_sensor_data' => new SensorDataResource($this->whenLoaded('latestSensorData')),

            // Summary data
            'total_waterings' => $this->when(isset($this->total_waterings), $this->total_waterings),
            'last_watered' => $this->when(isset($this->last_watered), $this->last_watered),
        ];
    }
}
