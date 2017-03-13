<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SOEvaluation extends Model
{
    protected $primaryKey = 'SOEval_Id';

    protected $table = 'outcome_requirement';

    protected $with = ['performanceIndicator', 'Requirement'];

    public function performanceIndicator() {
        return $this->belongsTo(PerformanceIndicator::class, 'PI_Id');
    }

    public function requirement() {
        return $this->belongsTo(CourseRequirement::class, 'Requirement_Id');
    }

    public function students() {
        return $this->belongsToMany(Student::class, 'outcome_student', 'SOEval_Id', 'Student_Id')->withPivot('Evaluation');
    }
}
