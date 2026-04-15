<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Booking;
class BookingStatusUpdated extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
  public function __construct(public Booking $booking) {}

    public function via(object $notifiable): array
    {
        return ['database','broadcast' ,'mail'];
    }


    // ─── Database ───────────────────────────────
    public function toArray(object $notifiable): array
    {
        return [
            'booking_id'  => $this->booking->id,
            'status'      => $this->booking->status,
            'doctor_name' => $this->booking->doctor->user->name ?? 'Doctor',
            'date'        => $this->booking->appointment_date,
            'message'     => 'Your appointment status has been updated to ' . ucfirst($this->booking->status),
        ];
    }

    // ─── Email ──────────────────────────────────
    public function toMail(object $notifiable): MailMessage
    {
        $statusColors = [
            'confirmed' => 'Confirmed ✅',
            'cancelled' => 'Cancelled ❌',
            'completed' => 'Completed 🏁',
            'pending'   => 'Pending ⏳',
        ];

        $label = $statusColors[$this->booking->status] ?? ucfirst($this->booking->status);

        return (new MailMessage)
            ->subject('Appointment Status Updated - ' . $label)
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line('Your appointment status has been updated.')
            ->line('**Status:** ' . $label)
            ->line('**Date:** ' . $this->booking->appointment_date)
            ->line('**Time:** ' . $this->booking->appointment_time)
            ->action('View Appointment', url('/'))
            ->line('Thank you for choosing our clinic!');
    }
}
