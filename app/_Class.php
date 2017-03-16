<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class _Class extends Model
{
    protected $primaryKey = 'Class_Id';

    protected $table = 'classes';

    protected $with = ['baseClass', 'section'];

    public function baseClass() {
        return $this->belongsTo(BaseClass::class, 'BaseClass_Id');
    }

    public function section() {
        return $this->belongsTo(Section::class, 'Section_Id');
    }

    public function students() {
        return $this->belongsToMany(Student::class, 'class_student', 'Class_Id')->withPivot('PrelimGrade', 'FinalGrade', 'SemestralGrade', 'TransmutedGrade');
    }
}
