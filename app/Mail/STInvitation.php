<?php

namespace App\Mail;

use App\Athlete;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class STInvitation extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var Athlete
     */
    public $athlete;


    /**
     * STInvitation constructor.
     * @param Athlete $athlete
     */
    public function __construct(Athlete $athlete)
    {
        $this->athlete = $athlete;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('North River Swim Team')
            ->with(['athlete', $this->athlete])
            ->markdown('email.STInvitation');
    }
}
