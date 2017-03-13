<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PerformanceIndicator extends Model
{
    protected $primaryKey = 'PI_Id';

    public function outcome() {
        return $this->belongsTo(StudentOutcome::class, 'Outcome_Id');
    }

    public function requirements() {
        return $this->belongsToMany(CourseRequirement::class, 'outcome_requirement', 'Outcome_Id', 'Requirement_Id');
    }
}
