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

}
