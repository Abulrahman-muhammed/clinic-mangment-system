<?php

namespace App\Models;

use App\Models\Major;
use App\Models\Booking;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Doctor extends Model
{
    use HasFactory;

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
        'status' =>'nullable|in:0,1',
        'user_id' => 'nullable|exists:users,id'
    ];

    public function major() {
        return $this->belongsTo(Major::class);
    }

    public function bookings() {
        return $this->hasMany(Booking::class);
    }
    public function schedules() {
        return $this->hasMany(DoctorSchedule::class);
    }
    public function user() {
        return $this->belongsTo(User::class);
    }
}
