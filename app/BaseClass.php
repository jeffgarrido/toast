<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BaseClass extends Model
{
    protected $primaryKey = 'BaseClass_Id';

    protected $table = 'course_professor';

    protected $with = ['course', 'professor'];

    public function course() {
        return $this->belongsTo(Course::class, 'Course_Id');
    }

    public function professor() {
        return $this->belongsTo(Professor::class, 'Professor_Id');
    }

    public function classes() {
        return $this->hasMany(_Class::class, 'BaseClass_Id');
    }
}
