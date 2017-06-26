<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SMS;

class SMSController extends Controller
{
    public function receiveHoursSMS(Request $request)
    {
       

        $incoming = \SMS::receive();
        //Get the sender's number.

        $incoming->from();
        //Get the message sent.
        //validate that it is a recognized number

        //Get the raw message
        $incoming->raw();
        //parse the text


        $content = "<Response><Message>" . $incoming->raw() . "</Message></Response>" ;

        return response()->make($content, '200')->header('Content-Type', 'text/xml');
        
    }

    public function retrieveMessage($id){

    	$incoming = SMS::getMessage($id);
		echo $incoming->raw()['status'];
    }
}
