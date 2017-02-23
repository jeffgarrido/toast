<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model as Model;

class User extends Authenticatable
{
    use Notifiable;

    public $primaryKey = "id";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'api_token', 'Access_Level'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'api_token'
    ];

    public function student(){
        return $this->hasOne(Student::class, 'Account_Id');
    }

    public function professor(){
        return $this->hasOne(Professor::class, 'Account_Id');
    }

    public function getUser($id){
        return $this-self::find($id);
    }

    public function deleteUser($id){
        return User::destroy($id);
    }
}
