<?php

namespace App\Mail;

use App\Tryout;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class TryoutReminder extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var Tryout
     */
    public $tryout;

    /**
     * TryoutReminder constructor.
     * @param Tryout $tryout
     */
    public function __construct(Tryout $tryout)
    {
        $this->tryout = $tryout;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Swim Team Tryout')
                    ->markdown('email.tryoutReminder')
                    ->with(['tryout', $this->tryout]);
    }
}
