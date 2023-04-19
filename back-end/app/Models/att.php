<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class att extends Model
{
    use HasFactory;


    protected $fillable = [
        'event_id',
        'id',
        'user_id',
        'qr',
        'face',
        'voice',
        'geo',
        'geoCheck',
        'done',
        'note',
        'attendKey',
        'instance_id',
    ];
}