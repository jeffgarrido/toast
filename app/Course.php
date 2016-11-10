<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    public function requirements(){
        return $this->hasMany(CourseRequirement::class, 'CourseID');
    }
}
