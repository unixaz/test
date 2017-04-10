<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'role', 'confirmed',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function isAdminOrProfessor()
    {
        if (Auth::user() && $this->role == 1 || Auth::user() && $this->role == 2)
        {
            return true;
        }
    }

    public function isAdmin()
    {
        if (Auth::user() && $this->role == 2)
        {
            return true;
        }
    }

    public function permission()
    {
        return $this->hasMany('App\Permission', 'user_id', 'id');
    }
}
