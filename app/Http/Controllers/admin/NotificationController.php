<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;

class NotificationController extends Controller
{
    // ─── All notifications (paginated) ──────────────
    public function index()
    {
        $notifications = auth()->user()
            ->notifications()
            ->paginate(15);

        return view('admin.notifications.index', compact('notifications'));
    }

    // ─── Mark single as read + redirect to its URL ──
    public function markAsRead(string $id)
    {
        $notification = auth()->user()
            ->notifications()
            ->findOrFail($id);

        $notification->markAsRead();

        return redirect($notification->data['url'] ?? route('admin.home'));
    }

    // ─── Mark all as read ───────────────────────────
    public function markAllAsRead()
    {
        auth()->user()->unreadNotifications->markAsRead();

        return back()->with('success', 'All notifications marked as read.');
    }

    // ─── Delete single ───────────────────────────────
    public function destroy(string $id)
    {
        auth()->user()
            ->notifications()
            ->findOrFail($id)
            ->delete();

        return back()->with('success', 'Notification removed.');
    }

    // ─── Clear all ───────────────────────────────────
    public function clearAll()
    {
        auth()->user()->notifications()->delete();

        return back()->with('success', 'All notifications cleared.');
    }
}