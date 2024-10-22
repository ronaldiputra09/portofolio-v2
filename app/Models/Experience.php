<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    // relationship with projects
    public function projects()
    {
        return $this->hasMany(Project::class);
    }
}
