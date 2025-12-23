<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receptionist extends Model
{
    use HasFactory;
    protected $fillable = [
        'address', 'image' ,'shift', 'status', 'user_id'
    ];
    protected $hidden = [
        'password',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
    
}
