<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\URL;

class Invite extends Mailable
{
    use Queueable, SerializesModels;


    protected $invite;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($invite)
    {
        $this->invite = $invite;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('app@bezorgfiets.nl','BEZORGFIETS')
            ->markdown('emails.invite',[
                'invite' => $this->invite,
                'url' => URL::route('signup', $this->invite->code)
            ]);
    }
}
