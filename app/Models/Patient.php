<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Patient extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'name',
        'email',
        'password',
        'date_of_birth',
        'phone',
        'gender',
        'blood_type',
        'address',
        'medical_history',
    ];
    protected $hidden = [
        'password',
    ];

  protected $casts = [
        'date_of_birth' => 'date',
    ];

    // ─── Relationships ────────────────────────────
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    // invoices
    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    // ─── Helpers ──────────────────────────────────
    public function getAgeAttribute(): ?int
    {
        return $this->date_of_birth
            ? $this->date_of_birth->age
            : null;
    }
    public function visits()
    {
        return $this->hasMany(Visit::class)->withTrashed();
    }
}
