<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Professor extends Model
{
    protected $primaryKey = 'Professor_Id';

    protected $fillable = ['FirstName', 'MiddleName', 'LastName', 'Phone', 'Email', 'Birthday'];

    public function account(){
        return $this->belongsTo(User::class, 'Account_Id');
    }

    public function courses() {
        return $this->belongsToMany(Course::class, 'classes');
    }

    public function organizations() {
        return $this->hasMany(Organization::class, 'Adviser_Id');
    }

    public function delete() {
        $account = $this->account()->get()->first();
        $account != null ? $account->delete(): '';
        $this->courses()->sync([]);
        foreach($this->organizations()->get() as $organization) {
            $organization->update(['Adviser_Id' => null]);
        }
        parent::delete();
    }
}
