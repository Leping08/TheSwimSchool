<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class TryoutsOpen extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var string
     */
    public $theme = 'the_swim_team';

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('North River Rapids Tryouts')
                    ->markdown('email.tryoutsOpen');
    }
}
