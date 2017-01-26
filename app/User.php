<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable, HasRoles;

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

     public function member()
     {
          return $this->hasOne(Member::class,'user_id');
     }
     
     
    public function serviceHours()
    {
        return $this->hasMany(Hours::class);
    }
    
    public function getUserByUsername( $username )
    {
        return $this->where('username', '=', $username)->first();
    }
    
   

    
}
