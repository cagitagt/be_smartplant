<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WateringHistoryResource extends JsonResource
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
            'irrigation_schedule_id' => $this->irrigation_schedule_id,
            'device_id' => $this->device_id,
            'watering_type' => $this->watering_type, // manual, scheduled, automatic
            'water_amount' => $this->water_amount, // in ml
            'duration' => $this->duration, // in minutes
            'soil_moisture_before' => $this->soil_moisture_before,
            'soil_moisture_after' => $this->soil_moisture_after,
            'watered_at' => $this->watered_at,
            'watered_by' => $this->watered_by, // user_id or 'system'
            'notes' => $this->notes,
            'success' => $this->success,
            'error_message' => $this->error_message,
            'created_at' => $this->created_at,

            // Relationships
            'plant' => new PlantResource($this->whenLoaded('plant')),
            'irrigation_schedule' => new IrrigationScheduleResource($this->whenLoaded('irrigationSchedule')),
            'device' => new DeviceResource($this->whenLoaded('device')),

            // Additional info
            'effectiveness' => $this->when(isset($this->effectiveness), $this->effectiveness), // calculated based on moisture change
        ];
    }
}
