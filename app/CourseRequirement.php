<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CourseRequirement extends Model
{
    protected $primaryKey = 'Requirement_Id';

    protected $table = 'course_requirements';

    protected $hidden = ['Term'];

    public function course(){
        return $this->belongsTo(_Class::class, 'Class_Id');
    }
}
