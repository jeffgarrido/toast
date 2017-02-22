<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Professor extends Model
{
    protected $primaryKey = 'ProfessorID';

    public function user(){
        return $this->belongsTo(Professor::class, 'AccountID');
    }
}
