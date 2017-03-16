<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudentOutcome extends Model
{
    protected $primaryKey = 'Outcome_Id';

    protected $table = 'student_outcomes';

    public function performanceIndicators() {
        return $this->hasMany(PerformanceIndicator::class, 'Outcome_Id');
    }

    public function students() {
        return $this->belongsToMany(Student::class, 'outcome_student',  'StudentOutcome_Id', 'Student_Id')->withPivot('Evaluation', 'P1', 'P2', 'P3');
    }

}
