<?php

namespace App\Observers;

use App\Models\Booking;
use App\Notifications\BookingStatusUpdated;
use Illuminate\Support\Facades\Log;
class BookingStatusObserverr
{
    public function updated(Booking $booking): void
    {
        // ✅ بس لو الـ status اتغير فعلاً
        if ($booking->wasChanged('status')) {
            $user = $booking->patient->user  // لو Patient عنده User
                 ?? $booking->user           // أو User مباشر على Booking
                ?? null;

            if ($user) {
                $user->notify(new BookingStatusUpdated($booking) );
            }
        }
    }
}
