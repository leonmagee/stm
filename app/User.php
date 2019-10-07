<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'company',
        'phone',
        'address',
        'city',
        'state',
        'zip',
        'role_id',
        'notes_email_disable',
        'email_blast_disable',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    // public function setPasswordAttribute($password)
    // {
    //     if ( $password !== null & $password !== "" )
    //     {
    //         $this->attributes['password'] = bcrypt($password);
    //     }
    // }

    /**
     * Query like this: $user->sims->find(2)->sim_number // this will return one sim with the id 2
     **/
    public function sims()
    {
        return $this->hasMany(SimUser::class);
    }

    /**
     * Link to Notes
     */
    public function notes()
    {
        return $this->hasMany(Note::class)->orderBy('created_at', 'DESC');
    }

    /**
     * @todo can probably remove this, or maybe just modify it?
     * instead of checking the role value, it will check the user_role pivot table?
     */
    public function isAdmin()
    {
        if ($this->role->id === 1) {
            return true;
        } else {
            return false;
        }
    }

    public static function getAdminUsers()
    {
        $users = self::where('role_id', 1)->get();
        return $users;
    }

    public static function getAdminManageerEmployeeUsers()
    {
        $users_array = [1, 2, 6];
        $users = self::whereIn('role_id', $users_array)->get();
        return $users;
        //dd($users);
    }

    public function isManager()
    {
        if ($this->role->id === 2) {
            return true;
        } else {
            return false;
        }
    }

    public function isEmployee()
    {
        if ($this->role->id === 6) {
            return true;
        } else {
            return false;
        }
    }

    public function isAdminManagerEmployee()
    {
        if (($this->role->id === 1) || ($this->role->id === 2) || ($this->role->id === 6)) {
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

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * @param string|array $roles
     */
    // public function authorizeRoles($roles)
    // {
    //   if (is_array($roles)) {
    //       return $this->hasAnyRole($roles) ||
    //              abort(401, 'This action is unauthorized.');
    //   }
    //   return $this->hasRole($roles) ||
    //          abort(401, 'This action is unauthorized.');
    // }

    /**
     * Check multiple roles
     * @param array $roles
     */
    // public function hasAnyRole($roles)
    // {
    //   return null !== $this->roles()->whereIn('name', $roles)->first();
    // }

    /**
     * Check one role
     * @param string $role
     */
    // public function hasRole($role)
    // {
    //   return null !== $this->roles()->where('name', $role)->first();
    // }

}
