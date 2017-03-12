<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $primaryKey = 'Student_Id';

    protected $fillable  = array('StudentNumber', 'FirstName', 'MiddleName', 'LastName', 'Birthday','Phone','PersonalEmail', 'created_at', 'updated_at','Nickname');

    public function section() {
        return $this->belongsTo(Section::class, 'Section_Id');
    }

    public function events() {
        return $this->belongsToMany(Event::class)->withPivot(array('PaymentStatus', 'Attendance'))->withTimestamps();
    }

    public function organizations() {
        return $this->belongsToMany(Organization::class)->withTimestamps()->withPivot('Position');
    }

    public function user(){
        return $this->belongsTo(Student::class, 'Account_Id');
    }

    public function classes() {
        return $this->belongsToMany(_Class::class);
    }
}
