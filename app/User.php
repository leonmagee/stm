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
        'contact_email_disable',
        'master_agent_site',
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

    public function isAdminManager()
    {
        if (($this->role->id === 1) || ($this->role->id === 2)) {
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

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function site_id()
    {
        $site = Site::where('role_id', $this->role->id)->first();
        return $site->id;
    }

}
