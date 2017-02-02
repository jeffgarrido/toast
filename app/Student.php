<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $primaryKey = 'Student_Id';

    public function events() {
        return $this->belongsToMany(Event::class);
    }
}
