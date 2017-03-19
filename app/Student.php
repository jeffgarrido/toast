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
        return $this->belongsToMany(_Class::class, 'Student_Id', 'Class_Id')->withPivot('PrelimGrade', 'FinalGrade', 'SemestralGrade', 'TransmutedGrade');
    }

    public function requirements() {
        return $this->belongsToMany(CourseRequirement::class, 'requirement_student', 'Student_Id', 'Requirement_Id')->withPivot('Score', 'id')->withTimestamps();
    }

    public function SOEvaluations() {
        return $this->belongsToMany(SOEvaluation::class, 'outcome_student', 'Student_Id', 'SOEval_Id')->withPivot('Evaluation', 'id');
    }

    public function studentOutcomes() {
        return $this->belongsToMany(StudentOutcome::class, 'so_student', 'Student_Id', 'StudentOutcome_Id')->withPivot('Evaluation', 'P1', 'P2', 'P3', 'EventEval');
    }
}
