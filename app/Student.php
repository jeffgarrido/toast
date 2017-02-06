<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $primaryKey = 'Student_Id';

    protected $fillable  = array('StudentNumber', 'FirstName', 'MiddleName', 'LastName', 'Birthday','Phone','PersonalEmail', 'created_at', 'updated_at','Nickname');

    public function events() {
        return $this->belongsToMany(Event::class)->withPivot(array('PaymentStatus', 'Attendance'))->withTimestamps();
    }

    public function organizations() {
        return $this->belongsToMany(Organization::class)->withTimestamps();
    }

    public function user(){
        return $this->belongsTo(Student::class, 'AccountID');
    }


}
