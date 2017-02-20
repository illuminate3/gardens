<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Email;

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
        dd($inbound);
        $this->email->processEmail($inbound);

        echo "<h2>All done!</h2>";
    }
    
    public function receiveHoursEmail()
    {
        $inbound = new \Postmark\Inbound(file_get_contents('php://input'));

        $this->email->processEmail($inbound);
    }
}
