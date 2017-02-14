<?php

namespace App\Mail;

use App\User;
use App\Post;
use App\Comment;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmailMessage extends Mailable
{
    use Queueable, SerializesModels;
    public $user;
    public $post;
    public $address;
    public $comment;
    public $name;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, Post $post, Comment $comment = null)
    {
        $this->user = $user;
        $this->post = $post;
        $this->address ='gardeners@mcneargardens.com';
        $this->name = env('APP_NAME');
        $this->comment = $comment;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.message')
        ->from($this->address,$this->name)
        ->subject($this->post->title . " [id=" . $this->post->id ."]" );
    }
}
