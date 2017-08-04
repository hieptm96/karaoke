<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    use EntrustUserTrait {
        can as entrustCan;
    }

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

    public function can($permission, $requireAll = false)
    {
        if ($this->isSuperAdmin()) {
            return true;
        }

        return $this->entrustCan($permission, $requireAll);
    }

    public function isSuperAdmin()
    {
        return $this->is_superadmin == 1;
    }

    public function ktv()
    {
        return $this->hasOne('App\Models\Ktv');
    }

    public function contentOwner()
    {
        return $this->hasOne('App\Models\ContentOwner');
    }

    public function roles()
    {
        return $this->belongsToMany('App\Models\Role');
    }
}
