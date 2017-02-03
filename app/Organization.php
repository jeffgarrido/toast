<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    protected $primaryKey = 'Organization_Id';

    public function events() {
        return $this->hasMany(Event::class);
    }
}
