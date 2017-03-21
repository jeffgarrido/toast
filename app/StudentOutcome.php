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
        return $this->belongsToMany(Student::class, 'so_student', 'StudentOutcome_Id', 'Student_Id')->withPivot('Evaluation', 'P1', 'P2', 'P3', 'EventEval');
    }

    public function events() {
        return $this->belongsToMany(Event::class, 'outcome_event','Outcome_Id','Event_Id')->withTimestamps();
    }

}
