<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attend extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'event_id',
        'grade',
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'users');
    }
}