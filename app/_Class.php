<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class _Class extends Model
{
    public function requirements() {
        return $this->hasMany(CourseRequirement::class);
    }
}
