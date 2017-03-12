<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CourseRequirement extends Model
{
    protected $primaryKey = 'Requirement_Id';

    protected $table = 'course_requirements';

    public function baseClass() {
        return $this->belongsTo(BaseClass::class, 'BaseClass_Id');
    }

    public function professor() {
        return $this->belongsTo(Professor::class, 'Professor_Id');
    }
}
