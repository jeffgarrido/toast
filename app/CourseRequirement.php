<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CourseRequirement extends Model
{
    protected $primaryKey = 'Requirement_Id';

    protected $table = 'course_requirements';

    public function baseClass() {
        return $this->belongsTo(BaseClass::class, 'BaseClass_Id');
    }

    public function professor() {
        return $this->belongsTo(Professor::class, 'Professor_Id');
    }

    public function outcomes() {
        return $this->belongsToMany(PerformanceIndicator::class, 'outcome_requirement', 'Requirement_Id', 'Outcome_Id');
    }

    public function students() {
        return $this->belongsToMany(Student::class, 'requirement_student', 'Requirement_Id');
    }
}
