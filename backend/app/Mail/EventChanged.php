<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

/**
 * Class EventChanged
 *
 * @author lacal
 */
class EventChanged extends Mailable
{
    use Queueable, SerializesModels;

    /*
     * Name of the event
     */
    public $event;

    /*
     * What was changed in the event
     */
    public $subjectName;

    /*
     * Value of the changed subject
     */
    public $subjectValue;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($event, $subjectName, $subjectValue)
    {
        $this->event = $event;
        $this->subjectName = $subjectName;
        $this->subjectValue = $subjectValue;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if ($this->subjectName == 'beginning') $emailSubject = 'Čas konania udalosti ' . $this->event->name . ' sa zmenil';
        elseif ($this->subjectName == 'place') $emailSubject = 'Miesto konania udalosti ' . $this->event->name . ' sa zmenilo';
        elseif ($this->subjectName == 'delete') $emailSubject = 'Udalosť ' . $this->event->name . ' bola zrušená';
        else {
            $emailSubject = 'Miesto a čas konania udaosti ' . $this->event->name . ' sa zmenili';
        }

        return $this->subject($emailSubject)->view('emails.event-changed');
    }
}
