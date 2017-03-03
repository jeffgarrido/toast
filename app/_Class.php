<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class _Class extends Model
{
    public function students() {
        return $this->belongsToMany(Student::class);
    }

    public function requirements() {
        return $this->hasMany(CourseRequirement::class);
    }


}
