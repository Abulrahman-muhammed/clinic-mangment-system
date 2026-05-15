<?php

namespace App\Notifications;

use App\Models\Visit;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Notifications\Messages\BroadcastMessage;

class NewVisitNotification extends Notification implements ShouldBroadcast
{
    use Queueable;

    public function __construct(public Visit $visit)
    {
        //
    }

    public function via(object $notifiable): array
    {
        return ['database', 'broadcast'];
    }

    // ─── Broadcast ─────────────────────────────
    public function toBroadcast(object $notifiable): BroadcastMessage
    {
        return new BroadcastMessage([
            'title'        => 'New Visit Assigned',
            'visit_id'     => $this->visit->id,
            'patient_name' => $this->visit->patient->name,
            'message'      => 'New visit assigned to you.',
        ]);
    }

    // ─── Database ──────────────────────────────
    public function toArray(object $notifiable): array
    {
        return [
            'title'         => 'New Visit Assigned',
            'visit_id'      => $this->visit->id,
            'patient_name'  => $this->visit->patient->name,
            'doctor_name'   => $this->visit->doctor->user->name,
            'status'        => $this->visit->status,
            'message'       => 'You have been assigned a new visit to you.',
            'url'           => route('admin.visit.show', $this->visit->id),
        ];
    }
}