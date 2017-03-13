<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
    protected $table = 'requirement_student';

    protected $with = ['requirement', 'student'];

    public function requirement() {
        return $this->belongsTo(CourseRequirement::class, 'Requirement_Id');
    }

    public function student() {
        return $this->belongsTo(Student::class, 'Student_Id');
    }
}
