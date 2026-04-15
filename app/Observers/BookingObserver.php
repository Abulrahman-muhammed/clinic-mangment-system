<?php

namespace App\Observers;

use App\Models\Booking;
use App\Models\User;
use App\Notifications\NewBookingNotification;
use Illuminate\Support\Facades\Log;

class BookingObserver
{
    public function created(Booking $booking): void
    {
        $booking->loadMissing('patient');

        // ── 1. الدكتور المعين للبوكينج ────────────────────
        $doctorUser = User::whereHas('doctor', function ($q) use ($booking) {
            $q->where('id', $booking->doctor_id);
        })->first();

        if ($doctorUser) {
            // ✅ نمرر الـ id في الـ constructor
            $doctorUser->notify(new NewBookingNotification($booking, $doctorUser->id));
            Log::info("[Notification] Sent to doctor #{$doctorUser->id} ({$doctorUser->email})");
        }

        // ── 2. كل الأدمنز ────────────────────────────────
        $admins = User::role('admin')->get();

        foreach ($admins as $admin) {
            // متبعتش مرتين لو الدكتور هو نفسه أدمن
            if ($doctorUser && $admin->id === $doctorUser->id) {
                continue;
            }
            // ✅ نمرر الـ id الخاص بكل أدمن
            $admin->notify(new NewBookingNotification($booking, $admin->id));
            Log::info("[Notification] Sent to admin #{$admin->id} ({$admin->email})");
        }
    }
}