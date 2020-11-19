<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EventRegister extends Mailable
{
    use Queueable, SerializesModels;


    public $eventid;
    public $email;



    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($eventid,$email)
    {
        $this->eventid = $eventid;
        $this->email = $email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Prihlásenie na event')->view('emails.event-register');
    }
}
