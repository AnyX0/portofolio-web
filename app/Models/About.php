<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class About extends Model
{
    protected $table = 'about';

    protected $fillable = [
        'name',
        'title',
        'email',
        'phone',
        'location',
        'availability',
        'timeline',
        'skills',
        'bio',
    ];

    protected $casts = [
        'timeline' => 'array',
        'skills' => 'array',
    ];
}
