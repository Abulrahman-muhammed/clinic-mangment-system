<?php

namespace App\Models;

use App\Models\Major;
use App\Models\Booking;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Doctor extends Model
{
    use HasFactory , SoftDeletes;

    protected $fillable = [
        'image',
        'major_id',
        'bio',
        'address',
        'gender',
        'consultation_fee',
        'years_of_experience',
        'status',
        'user_id'
    ];

    public const IMAGE_PATH = 'images/doctors/';

    public static $rules = [
        'major_id' =>'required|exists:majors,id',
        'bio' =>'nullable|string',
        'address' =>'nullable|string|max:255',
        'gender' =>'nullable|in:male,female',
        'consultation_fee' =>'nullable|numeric|min:0',
        'years_of_experience' =>'nullable|integer|min:0',
        'user_id' => 'nullable|exists:users,id'
    ];

    public function major() {
        return $this->belongsTo(Major::class)->withTrashed();
    }

    public function bookings() {
        return $this->hasMany(Booking::class);
    }
    public function schedules() {
        return $this->hasMany(DoctorSchedule::class);
    }
    // invoices
    public function invoices() {
        return $this->hasMany(Invoice::class)->withTrashed();
    }
    // visits
    public function visits() {
        return $this->hasMany(Visit::class)->withTrashed();
    }
    public function user() {
        return $this->belongsTo(User::class)->withTrashed();
    }
}
