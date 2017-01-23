<?php
namespace App;

use Illuminate\Database\Eloquent\Model;




class Member extends Model {

	// Add your validation rules here
	public  $rules = [
		'firstname'=>'required',
		'lastname'=>'required',
		'address'=>'required'
	];

	// Don't forget to fill this array
	public $fillable = ['firstname','middlename','lastname','address','phone','mobile','user_id','status','membersince','carrier'];
 	
	public function plots()
	{
		return $this->belongsToMany(Plot::class);
	}
	
	public function servicehours()
    {
        return $this->hasMany(Hours::class,'user_id');
    }
	public function userdetails()
    {
        return $this->hasOne(User::class,'id','user_id');
    }
}