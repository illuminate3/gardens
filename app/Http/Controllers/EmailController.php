<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Email;
use SMS;
class EmailController extends Controller
{
    public $email;
    /**
     * Display a listing of the resource.
     * GET /emailcontroller
     *
     * @return Response
     */
    public function __construct(Email $email)
    {
        $this->email = $email;
    }


    public function testemail()
    {
        return view('emails.parsetest');
    }
    
    public function getEmail()
    {
        $inbound = new \Postmark\Inbound(file_get_contents('inbound.json'));
       
        $this->email->processEmail($inbound);

        echo "<h2>All done!</h2>";
    }
    
    public function receiveHoursEmail()
    {
        $input = file_get_contents('php://input');
        if($input){
            $inbound = new \Postmark\Inbound($input);
        
            $this->email->processEmail($inbound);
        }
        return redirect('/');
    }

    public function receiveHoursSMS(Request $request)
    {
        
        $incoming = SMS::receive();
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
}
