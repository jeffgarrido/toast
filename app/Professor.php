<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Professor extends Model
{
    protected $primaryKey = 'Professor_Id';

    public function user(){
        return $this->belongsTo(Professor::class, 'AccountID');
    }

    public function courses() {
        return $this->hasMany(Course::class, 'classes');
    }
}
