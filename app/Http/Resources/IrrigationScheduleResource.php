<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class IrrigationScheduleResource extends JsonResource
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
            'schedule_name' => $this->schedule_name,
            'frequency' => $this->frequency, // daily, weekly, custom
            'time' => $this->time,
            'duration' => $this->duration, // in minutes
            'days_of_week' => $this->days_of_week, // JSON array for weekly schedule
            'water_amount' => $this->water_amount, // in ml
            'is_active' => $this->is_active,
            'moisture_threshold' => $this->moisture_threshold,
            'auto_irrigation' => $this->auto_irrigation,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

            // Relationships
            'plant' => new PlantResource($this->whenLoaded('plant')),

            // Next scheduled time
            'next_schedule' => $this->when(isset($this->next_schedule), $this->next_schedule),
        ];
    }
}
