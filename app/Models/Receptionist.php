<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Receptionist extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'address', 'image' ,'shift', 'status', 'user_id'
    ];
    protected $hidden = [
        'password',
    ];

    public function user() {
        return $this->belongsTo(User::class)->withTrashed();
    }
    
}
