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
        'name', 'email', 'password','username','confirmation_code','api_controller'
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
        return $this->hasOne(Member::class,'user_id','id');
    }
     
     
    public function serviceHours()
    {
        return $this->hasMany(Hours::class);
    }
    
    public function getUserByUsername($username)
    {
        return $this->where('username', '=', $username)->first();
    }
    
    public function getUsersMemberId()
    {
        $member = $this->member()->first();
        return $member->id;
    }

    
    public function getUsersPlot()
    {
        $user = $this->with('member', 'member.plots')->first();
        $plots=array();
        if (isset($user->member->plots)) {
            foreach ($user->member->plots as $plot) {
                $plots[]=$plot->id;
            }
        }
        return $plots;
    }
     
    public function currentYearHours()
    {
        $year = date('Y');
    
        return $this->hasMany(Hours::class)
                ->where('starttime', 'like', $year."%")
                ->orderBy('starttime');
        ;
    }

    public function sumCurrentHours()
    {
        $year = date('Y');
    
        return $this->hasMany(Hours::class)
                ->where('starttime', 'like', $year."%")
                ->groupBy('user_id')
            ->sum('hours')
        ;
    }

    public function seeder(){
        $this->api_token =\Hash::make(str_random(60));
        $this->save();
    }
}
