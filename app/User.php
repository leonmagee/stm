<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','company', 'phone', 'address', 'city', 'state', 'zip', 'role'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
    * Query like this: $user->sims->find(2)->sim_number // this will return one sim with the id 2
    **/
    public function sims() {
        return $this->hasMany(SimUser::class);
    }

    /**
    * @todo can probably remove this, or maybe just modify it?
    * instead of checking the role value, it will check the user_role pivot table?
    */
    public function isAdmin() {
        if ( $this->role === 'admin') {
            return true;
        } else {
            return false;
        }
    }

    /**
    * @todo create a different role for Juan and Jessica?
    * Not sure what will be different? Just have the ability to upload sims?
    * Prob need a different homepage view.. 
    */
    // public function isManager() {
    //     if ( $this->role === 'manager') {
    //         return true;
    //     } else {
    //         return false;
    //     }
    // }

    public function roles()
    {
      return $this->belongsToMany(Role::class);
    }


}
