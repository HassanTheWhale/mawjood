<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class eventCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'picture',
    ];


    public function categories()
    {
        return $this->belongsTo(eventCategory::class, 'categories');
    }
}