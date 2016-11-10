<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CourseRequirement extends Model
{
    protected $hidden = ['Term'];
    public function course(){
        return $this->belongsTo(Course::class);
    }
}
