<?php

namespace Benwilkins\FCM\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FCM extends Model
{
    use HasFactory;
    
    protected $table = 'fcm';
    protected $fillable = [
        'user_id',
        'token'
    ];
}