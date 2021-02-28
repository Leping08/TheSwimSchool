<?php

namespace App\Mail\SwimTeam;

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
        return $this->subject('Fall Swim Club Tryouts')
            ->from(config('mail.from.address'))
            ->markdown('email.swim-team.tryoutsOpen')
            ->with(['emailAddress' => $this->emailAddress]);
    }
}
