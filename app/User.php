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
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function student(){
        return $this->hasOne(Student::class, 'AccountID');
    }

    public function professor(){
        return $this->hasOne(Professor::class, 'AccountID');
    }

    public function getUser($id){
    }

    public function deleteUser($id){
        $this-self::destroy($id);
    }
}
