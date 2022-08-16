<?php

namespace App\Mail\SwimTeam;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Awards extends Mailable
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
        return $this->markdown('email.swim-team.awards')
            ->from(config('mail.from.address'))
            ->subject('Parrish Bull Sharks Awards Dinner');
    }
}
