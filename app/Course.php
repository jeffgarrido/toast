<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    public $primaryKey = "Course_Id";

    public function requirements() {
        return $this->hasMany(CourseRequirement::class, 'Course_Id');
    }

    public function professors() {
        return $this->belongsToMany(Professor::class)->withTimestamps()->withPivot('BaseClass_Id');
    }

    public function outcomes() {
        return $this->belongsToMany(StudentOutcome::class, 'course_outcome', 'Course_Id', 'Outcome_Id')->withTimestamps();
    }
}
