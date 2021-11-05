<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ForgotPass extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $email;
    protected $hash;
    protected $nick_name;
    protected $request_expired;

    public function __construct($email, $hash,$nick_name,$request_expired)
    {

        $this->email = $email;
        $this->hash = $hash;
        $this->nick_name = $nick_name;
        $this->request_expired = $request_expired;

    }

    /**
     * Build the message.
     *
     * @return $this
     */

    public function build()
    {   
        return $this->view('Backend.resetPassword.resetPass',['email'=>$this->email, 'hash' => $this->hash,'nick_name'=>$this->nick_name, 'request_expired' => $this->request_expired]);
    }
}
