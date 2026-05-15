<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Invoice extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'patient_id', 'doctor_id', 'user_id', 'invoice_date', 'status', 'amount', 'notes', 'visit_id'
    ];

    // Relationships
    public function patient()
    {
        return $this->belongsTo(Patient::class)->withTrashed();
    }
    public function doctor()
    {
        return $this->belongsTo(Doctor::class)->withTrashed();
    }
    public function user()
    {
        return $this->belongsTo(User::class)->withTrashed();   
    }
    public function visit()
    {
        return $this->belongsTo(Visit::class)->withTrashed();
    }
    public function services()
    {
        return $this->hasMany(InvoiceService::class);
    }
}
