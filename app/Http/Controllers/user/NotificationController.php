<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
 // ─── All notifications (paginated + filter) ──────────────
    public function index(Request $request)
    {
        $user        = auth()->user();
        $unreadCount = $user->unreadNotifications->count();
        $filter      = $request->get('filter', 'all');
 
        $query = $user->notifications();
 
        if ($filter === 'unread') {
            $query->whereNull('read_at');
        } elseif (in_array($filter, ['confirmed', 'pending', 'cancelled', 'completed'])) {
            $query->where('data->status', $filter);
        }
 
        $notifications = $query->paginate(10);
 
        // Stats (always from all notifications, not filtered)
        $allNotifications = $user->notifications()->get();
        $stats = [
            'total'     => $user->notifications()->count(),
            'unread'    => $unreadCount,
            'confirmed' => $allNotifications->where('data.status', 'confirmed')->count(),
            'pending'   => $allNotifications->where('data.status', 'pending')->count(),
            'cancelled' => $allNotifications->where('data.status', 'cancelled')->count(),
            'completed' => $allNotifications->where('data.status', 'completed')->count(),
        ];
 
        return view('front.notifications.index', compact('notifications', 'unreadCount', 'stats', 'filter'));
    }
 
    // ─── Mark single as read ──────────────────────────────────
    public function markAsRead(string $id)
    {
        $notification = auth()->user()
            ->notifications()
            ->findOrFail($id);
 
        $notification->markAsRead();
 
        return back()->with('success', 'Notification marked as read.');
    }
 
    // ─── Mark all as read ─────────────────────────────────────
    public function markAllAsRead()
    {
        auth()->user()->unreadNotifications->markAsRead();
 
        return back()->with('success', 'All notifications marked as read.');
    }
 
    // ─── Delete single ────────────────────────────────────────
    public function destroy(string $id)
    {
        auth()->user()
            ->notifications()
            ->findOrFail($id)
            ->delete();
 
        return back()->with('success', 'Notification deleted.');
    }
    }
