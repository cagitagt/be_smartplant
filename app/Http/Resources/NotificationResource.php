<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
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
            'user_id' => $this->user_id,
            'type' => $this->type, // watering_due, low_moisture, device_offline, etc.
            'title' => $this->title,
            'message' => $this->message,
            'priority' => $this->priority, // low, medium, high, critical
            'status' => $this->status, // unread, read, dismissed
            'action_required' => $this->action_required,
            'action_url' => $this->action_url,
            'data' => $this->data, // JSON additional data
            'sent_at' => $this->sent_at,
            'read_at' => $this->read_at,
            'dismissed_at' => $this->dismissed_at,
            'created_at' => $this->created_at,

            // Relationships
            'plant' => new PlantResource($this->whenLoaded('plant')),

            // Formatted data
            'formatted_message' => $this->when(isset($this->formatted_message), $this->formatted_message),
            'time_ago' => $this->when(isset($this->time_ago), $this->time_ago),
            'icon' => $this->when(isset($this->icon), $this->icon),
            'color' => $this->when(isset($this->color), $this->color),
        ];
    }
}
