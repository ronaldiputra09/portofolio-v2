<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class License extends Model
{
    protected $casts = [
        'skills' => 'array',
        'is_lifetime' => 'boolean',
    ];
}
