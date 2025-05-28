<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\NotificationResource;
use App\Models\Notification;
use App\Models\Plant;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request, Plant $plant): JsonResponse
    {
        $this->authorize('view', $plant);

        $notifications = $plant->notifications()
            ->when($request->type, function ($query, $type) {
                return $query->where('type', $type);
            })
            ->when($request->priority, function ($query, $priority) {
                return $query->where('priority', $priority);
            })
            ->when($request->unread_only, function ($query) {
                return $query->where('is_read', false);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return response()->json([
            'success' => true,
            'data' => NotificationResource::collection($notifications),
            'meta' => [
                'current_page' => $notifications->currentPage(),
                'last_page' => $notifications->lastPage(),
                'per_page' => $notifications->perPage(),
                'total' => $notifications->total(),
                'unread_count' => $plant->notifications()->where('is_read', false)->count(),
            ]
        ]);
    }

    public function show(Plant $plant, Notification $notification): JsonResponse
    {
        $this->authorize('view', $plant);

        if ($notification->plant_id !== $plant->id) {
            return response()->json([
                'success' => false,
                'message' => 'Notification not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => new NotificationResource($notification)
        ]);
    }

    public function markAsRead(Plant $plant, Notification $notification): JsonResponse
    {
        $this->authorize('view', $plant);

        if ($notification->plant_id !== $plant->id) {
            return response()->json([
                'success' => false,
                'message' => 'Notification not found'
            ], 404);
        }

        $notification->update([
            'is_read' => true,
            'read_at' => now()
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Notification marked as read',
            'data' => new NotificationResource($notification)
        ]);
    }

    public function markAllAsRead(Plant $plant): JsonResponse
    {
        $this->authorize('view', $plant);

        $plant->notifications()
            ->where('is_read', false)
            ->update([
                'is_read' => true,
                'read_at' => now()
            ]);

        return response()->json([
            'success' => true,
            'message' => 'All notifications marked as read'
        ]);
    }

    public function destroy(Plant $plant, Notification $notification): JsonResponse
    {
        $this->authorize('view', $plant);

        if ($notification->plant_id !== $plant->id) {
            return response()->json([
                'success' => false,
                'message' => 'Notification not found'
            ], 404);
        }

        $notification->delete();

        return response()->json([
            'success' => true,
            'message' => 'Notification deleted successfully'
        ]);
    }
}
