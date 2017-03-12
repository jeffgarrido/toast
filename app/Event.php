<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $primaryKey = 'Event_Id';

    public function students() {

        return $this->belongsToMany(Student::class)->withPivot(array('PaymentStatus', 'Attendance'))->withTimestamps();
    }

    public function studentslist() {

        return $this->belongsToMany(Student::class)->withPivot(array('PaymentStatus', 'Attendance'))->wherePivot('Attendance', '!=', 'null')->withTimestamps();

    }

    public function organization() {
        return $this->belongsTo(Organization::class, 'Organization_Id');
    }

    protected $fillable  = array('Event_Name','Organization_Id','Event_Date','Start_Time','End_Time','Venue','Description',);
}
