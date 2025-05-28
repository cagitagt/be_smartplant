<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class NotificationCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'data' => NotificationResource::collection($this->collection),
            'meta' => [
                'total_notifications' => $this->collection->count(),
                'unread_count' => $this->collection->where('status', 'unread')->count(),
                'high_priority_count' => $this->collection->whereIn('priority', ['high', 'critical'])->count(),
            ]
        ];
    }
}
