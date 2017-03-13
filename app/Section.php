<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    protected $primaryKey = 'Section_Id';

    protected $fillable = ['Code', 'AcademicYearStart', 'AcademicYearEnd'];

    public function classes() {
        return $this->hasMany(_Class::class, 'classes', 'Section_Id')->withPivot('Class_Id')->withTimestamps();
    }

    public function students() {
        return $this->hasMany(Student::class, 'Section');
    }
}
