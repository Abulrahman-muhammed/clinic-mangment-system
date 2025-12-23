<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;
    protected $fillable = [
        'patient_id', 'doctor_id', 'user_id', 'invoice_date', 'status', 'amount', 'notes'
    ];

    // Relationships
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);   
    }
    public function services()
    {
        return $this->hasMany(InvoiceService::class);
    }
}
