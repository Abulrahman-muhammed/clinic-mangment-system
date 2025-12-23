<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;
    protected $fillable = [
    'name', 'email', 'password', 'date_of_birth', 'phone',
    'gender', 'blood_type', 'address', 'medical_history'
];
    protected $hidden = [
        'password',
    ];
}
