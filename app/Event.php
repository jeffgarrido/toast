<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $primaryKey = 'Event_Id';

    public function students() {
        return $this->belongsToMany(Student::class)->withTimestamps();
    }
}
