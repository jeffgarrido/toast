<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CourseRequirement extends Model
{
    protected $primaryKey = 'Requirement_Id';

    protected $table = 'course_requirements';

    public function course() {
        return $this->belongsTo(Course::class, 'Course_Id');
    }

    public function professor() {
        return $this->belongsTo(Professor::class, 'Professor_Id');
    }

    public function outcomes() {
        return $this->belongsToMany(PerformanceIndicator::class, 'outcome_requirement', 'Requirement_Id', 'PI_Id')->withPivot('SOEval_Id');
    }

    public function students() {
        return $this->belongsToMany(Student::class, 'requirement_student', 'Requirement_Id')->withPivot('Score', 'id')->withTimestamps();
    }
}
