<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    protected $casts = [
        'skills' => 'array',
        'is_current' => 'boolean',
    ];

    // relationship with projects
    public function projects()
    {
        return $this->hasMany(Project::class);
    }
}
