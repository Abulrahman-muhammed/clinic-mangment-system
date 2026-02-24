<?php

namespace App\Models;

use App\Models\Doctor;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
    
use Illuminate\Database\Eloquent\SoftDeletes;
class Booking extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'user_id',
        'doctor_id',
        'patient_id',
        'service_id',
        'appointment_date',
        'appointment_time',
        'payment_method',
        'amount',
        'payment_status',
        'card_name',
        'card_last4',
        'card_expiry',
        'status',
        'notes',
    ];

    protected $casts = [
        'appointment_date' => 'date',
        'amount'           => 'decimal:2',
    ];// ─── Relationships ───────────────────────────
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

     // ─── Booking creation logic (in Controller) ───────────────────────────────

    // ─── Helpers ─────────────────────────────────
    public function isPaid(): bool
    {
        return $this->payment_status === 'paid';
    }

    public function isConfirmed(): bool
    {
        return $this->status === 'confirmed';
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function getFormattedTimeAttribute(): string
    {
        return \Carbon\Carbon::parse($this->appointment_time)->format('g:i A');
    }

    public function getFormattedDateAttribute(): string
    {
        return $this->appointment_date->format('D, d M Y');
    }

    public function getStatusBadgeClassAttribute(): string
    {
        return match($this->status) {
            'confirmed'  => 'badge-success',
            'cancelled'  => 'badge-danger',
            'completed'  => 'badge-info',
            default      => 'badge-warning',
        };
    }

    public function getPaymentBadgeClassAttribute(): string
    {
        return match($this->payment_status) {
            'paid'      => 'badge-success',
            'failed'    => 'badge-danger',
            'refunded'  => 'badge-info',
            default     => 'badge-warning',
        };
    }
}
