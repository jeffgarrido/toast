<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CourseRequirement extends Model
{
    protected $primaryKey = 'Requirement_Id';

    protected $table = 'course_requirements';

    public function _class() {
        return $this->belongsTo(_Class::class);
    }


}
