<?php

namespace App\Http\Controllers;

use App\Models\Alert;
use Illuminate\Http\Request;

class AlertController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the alerts.
     */
    public function index()
    {
        $alerts = auth()->user()->alerts()->latest()->paginate(10);
        return view('alerts.index', compact('alerts'));
    }

    /**
     * Mark an alert as read.
     */
    public function markAsRead(Alert $alert)
    {
        if ($alert->user_id !== auth()->id()) {
            abort(403);
        }

        $alert->update(['is_read' => true]);

        return response()->json(['success' => true]);
    }

    /**
     * Mark all alerts as read.
     */
    public function markAllAsRead()
    {
        auth()->user()->alerts()->update(['is_read' => true]);

        return response()->json(['success' => true]);
    }

    /**
     * Delete an alert.
     */
    public function destroy(Alert $alert)
    {
        if ($alert->user_id !== auth()->id()) {
            abort(403);
        }

        $alert->delete();

        return response()->json(['success' => true]);
    }

    /**
     * Get unread alerts count.
     */
    public function getUnreadCount()
    {
        $count = auth()->user()->unreadAlerts()->count();
        return response()->json(['count' => $count]);
    }
}
