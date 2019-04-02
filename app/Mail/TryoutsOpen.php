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
     * @var
     */
    public $emailAddress;

    /**
     * Create a new message instance.
     * @param $emailAddress
     * @return void
     */
    public function __construct($emailAddress)
    {
        $this->emailAddress = $emailAddress;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('North River Rapids Tryouts')
                    ->markdown('email.tryoutsOpen')
                    ->with(['emailAddress', $this->emailAddress]);
    }
}
