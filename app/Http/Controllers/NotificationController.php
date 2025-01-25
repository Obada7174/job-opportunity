<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function getNotifications(Request $request)
    {
        $user = Auth::user();

        $perPage = $request->get('per_page', 10); 
        $notifications = $user->notifications()->paginate($perPage);

        return response()->json([
            'notifications' => $notifications,
        ]);
    }

    public function markAsRead($notificationId)
    {
        $user = Auth::user();
        $notification = $user->notifications()->find($notificationId);

        if ($notification) {
            $notification->markAsRead();
        }

        return response()->json(['message' => 'notice is marked as read']);
    }
}