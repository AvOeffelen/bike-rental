<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
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
        'name','lastname_addition','lastname', 'email', 'password','phone','type'
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
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    const OWNER_TYPE = 'owner';
    const ADMIN_TYPE = 'admin';
    const LOCATION_MANAGER = 'location';
    //Created this just in case mechanic have different behaviours
    const MECHANIC_TYPE = 'mechanic';

    
    public function isOwner()
    {
        return $this->type === self::OWNER_TYPE;

    }

    public function isLocationManager()
    {
        return $this->type === self::LOCATION_MANAGER;
    }

    public function isMechanic()
    {
        return $this->type === self::MECHANIC_TYPE;
    }

    public function isAdmin()
    {
        return $this->type === self::ADMIN_TYPE;
    }

}
