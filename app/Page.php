<?php

namespace App;


use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use App\Mail\SendContactFormEmail;
use App\Mail\NotifyContactFormEmail;
use App\Form;

class Page extends Model
{
	
	public function sendFormEmails($data){

        \Mail::to($data['email'])->send(new SendContactFormEmail($data));
        \Mail::to('info@mcneargardens.com')->send(new NotifyContactFormEmail($data));
        $form = Form::create($data);
	}
}