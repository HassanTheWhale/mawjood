<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class events extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'picture',
        'min_grade',
        'type',
        'start_date',
        'end_date',
        'start_time',
        'end_time',
        'strange',
        'private',
        'key',
        'attendKey',
        'closed',
        'user_id',
        'category',
    ];

    public function users()
    {
        return $this->belongsTo(User::class, 'users');
    }

    public function dates()
    {
        return $this->hasMany(EventInstances::class, 'event_id');
    }
}