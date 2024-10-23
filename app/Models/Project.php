<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Experience;

class Project extends Model
{
    protected $casts = [
        'skills' => 'array',
        'images' => 'array',
    ];

    // relationship with experiences
    public function experiences()
    {
        return $this->belongsTo(Experience::class, 'experience_id', 'id', 'experiences');
    }
}
