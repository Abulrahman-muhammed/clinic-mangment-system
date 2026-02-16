<?php

namespace App\Models;

use App\Models\Doctor;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'date',
        'doctor_id',
        'status'
    ];

    protected $casts = [
        'date' => 'date',
    ];

 public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    /**
     * العلاقة مع المريض - أضف دي
     */
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    /**
     * العلاقة مع الـ User (لو المريض user)
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }

    /**
     * العلاقة مع الـ Invoice
     */
    public function invoice()
    {
        return $this->hasOne(Invoice::class);
    }
}
