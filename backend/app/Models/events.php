<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class events extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'follow_id',
    ];

    // check this
    public function events()
    {
        return $this->belongsTo(events::class, 'events');
    }
}