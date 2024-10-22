<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    // relationship with experiences
    public function experiences()
    {
        return $this->belongsTo(Experience::class);
    }
}
