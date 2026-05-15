<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Visit extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'patient_id',
        'doctor_id',
        'receptionist_id',
        'status',
        'notes',
    ];
        // 👤 Patient
        public function patient()
        {
            return $this->belongsTo(Patient::class);
        }
    
        // 👨‍⚕️ Doctor
        public function doctor()
        {
            return $this->belongsTo(Doctor::class);
        }
    
        // 👩‍💼 Receptionist (user)
        public function receptionist()
        {
            return $this->belongsTo(User::class, 'receptionist_id');
        }
    
        // 💰 Invoice
        public function invoice()
        {
            return $this->hasOne(Invoice::class);
        }
}
