<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Mail\SendWaitListConfirmation;
use App\Mail\SendWaitListNotify;
class Member extends Model
{

    // Add your validation rules here
    public $rules = [
        'firstname'=>'required',
        'lastname'=>'required',
        'address'=>'required'
    ];
    protected $dates = ['membersince'];
    // Don't forget to fill this array
    public $fillable = ['firstname','middlename','lastname','address','phone','mobile','status','membersince','carrier'];
    
    public function plots()
    {
        return $this->belongsToMany(Plot::class);
    }
    
    public function hours(){
        return $this->hasMany(Hours::class,'user_id','user_id');
    }
    
    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function sendWaitListEmails($data){
        \Mail::to($data['email'])->send(new SendWaitListConfirmation($data));
        \Mail::to('info@mcneargardens.com')->send(new SendWaitListNotify($data));
        
    }

    public function getWaitList(){

        return $this->where('status','=','wait')->get();
    }

    public function fullname (){
        return $this->firstname . " " . $this->lastname;
    }
}
