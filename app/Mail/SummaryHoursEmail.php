<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SummaryHoursEmail extends Mailable
{
    use Queueable, SerializesModels;
    public $plotemail;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($plotemail)
    {
        $this->plotemail = $plotemail;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {


        return $this->view('emails.summary')
                ->subject('Your '. date('Y').' service hours');
    }
}
