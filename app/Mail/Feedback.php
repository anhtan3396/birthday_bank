<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Feedback extends Mailable
{
    use Queueable, SerializesModels;

    /**
     *   
     *
     * Create a new message instance.
     *
     * @return void
     */
    
    protected $email;
    protected $content_reply;
    public function __construct($email,$content_reply)
    {
        $this->email = $email;
        $this->content_reply = $content_reply;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('Backend.feedback.mail_feedback',['email'=>$this->email,'content_reply'=>$this->content_reply]);
    }
}
