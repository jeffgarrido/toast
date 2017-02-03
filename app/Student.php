<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $primaryKey = 'Student_Id';

    public function events() {
        return $this->belongsToMany(Event::class);
    }

    public function user(){
        return $this->belongsTo(Student::class, 'AccountID');
    }
}
