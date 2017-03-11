<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class _Class extends Model
{
    protected $primaryKey = 'Class_Id';

    protected $table = 'classes';

    protected $with = ['course', 'professor', 'section'];

    public function course() {
        return $this->belongsTo(Course::class, 'Course_Id');
    }

    public function professor() {
        return $this->belongsTo(Professor::class, 'Professor_Id');
    }

    public function section() {
        return $this->belongsTo(Section::class, 'Section');
    }

    public function students() {
        return $this->belongsToMany(Student::class, 'class_student', 'Class_Id');
    }

    public function requirements() {
        return $this->hasMany(CourseRequirement::class, 'Class_Id');
    }


}
