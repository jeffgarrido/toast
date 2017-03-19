<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $primaryKey = 'Event_Id';

    public function studentslist() {

        return $this->belongsToMany(Student::class)->withPivot(array('PaymentStatus', 'Attendance'))->withTimestamps();
    }

    public function students() {

        return $this->belongsToMany(Student::class)->withTimestamps();

    }

    public function organization() {
        return $this->belongsTo(Organization::class, 'Organization_Id');
    }

    public function studentOutcomes() {
        return $this->belongsToMany(StudentOutcome::class, 'outcome_event','Event_Id','Outcome_Id')->withTimestamps();
    }

    protected $fillable  = array('Event_Name','Organization_Id','Event_Date','Start_Time','End_Time','Venue','Description',);
}
