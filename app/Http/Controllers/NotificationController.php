<?php

namespace App\Http\Controllers;

use App\Models\SystemNotification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $notifications = auth()->user()->systemNotifications()->latest()->paginate(10);
        return view('notifications.index', compact('notifications'));
    }

    public function getUnreadCount()
    {
        $count = auth()->user()->unreadSystemNotifications()->count();
        return response()->json(['count' => $count]);
    }

    public function getLatest()
    {
        $notifications = auth()->user()->systemNotifications()
            ->latest()
            ->take(5)
            ->get();
        return response()->json($notifications);
    }

    public function markAsRead($id)
    {
        $notification = SystemNotification::findOrFail($id);

        if ($notification->user_id !== auth()->id()) {
            abort(403);
        }

        $notification->update(['is_read' => true]);
        return response()->json(['success' => true]);
    }

    public function markAllAsRead()
    {
        auth()->user()->systemNotifications()->update(['is_read' => true]);
        return response()->json(['success' => true]);
    }

    public function destroy($id)
    {
        $notification = SystemNotification::findOrFail($id);

        if ($notification->user_id !== auth()->id()) {
            abort(403);
        }

        $notification->delete();
        return response()->json(['success' => true]);
    }
}
