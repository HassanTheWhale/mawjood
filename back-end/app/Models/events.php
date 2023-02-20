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
        'start_date',
        'strange',
        'private',
        'user_id',
    ];

    // check this
    public function events()
    {
        return $this->belongsTo(events::class, 'events');
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'users');
    }
}