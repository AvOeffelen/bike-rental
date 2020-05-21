<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailVerification extends Mailable
{
    use Queueable, SerializesModels;

    public $verifyUrl;
    public $user;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($verifyUrl,$user)
    {
        $this->verifyUrl = $verifyUrl;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->markdown('emails.verify-email', ['user' => $this->user, 'verifyUrl' => $this->verifyUrl])->subject("welcome!");
    }
}
