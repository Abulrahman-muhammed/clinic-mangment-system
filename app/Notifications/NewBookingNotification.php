<?php

namespace App\Notifications;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Broadcasting\PrivateChannel;

class NewBookingNotification extends Notification  implements ShouldBroadcast
{
    use Queueable;

    public function __construct(
        public Booking $booking,
        public int $notifiableId  // ✅ بنمرره من الـ Observer مباشرة
    ) {}

    public function via(object $notifiable): array
    {
        return ['database', 'broadcast'];
    }

    // ✅ broadcastOn بدون parameters — بتستخدم الـ id اللي جاي في الـ constructor
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('App.Models.User.' . $this->notifiableId),
        ];
    }

    public function toDatabase(object $notifiable): array
    {
        return $this->payload();
    }

    public function toBroadcast(object $notifiable): BroadcastMessage
    {
        return new BroadcastMessage($this->payload());
    }

    private function payload(): array
    {
        return [
            'title'      => 'New Booking',
            'message'    => 'New appointment booked for ' . ($this->booking->patient->name ?? 'a patient'),
            'booking_id' => $this->booking->id,
            'patient_id' => $this->booking->patient_id,
            'date'       => $this->booking->appointment_date,
            'time'       => $this->booking->appointment_time,
            'icon'       => 'fe-calendar',
            'color'      => 'primary',
            'url'        => route('admin.doctor.myBookings'),
        ];
    }
}