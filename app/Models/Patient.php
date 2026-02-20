<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Patient extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
    'name', 'email', 'password', 'date_of_birth', 'phone',
    'gender', 'blood_type', 'address', 'medical_history'
];
    protected $hidden = [
        'password',
    ];


}
