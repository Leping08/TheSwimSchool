<?php

namespace App\Mail\SwimTeam;

use App\STSwimmer;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class STSignUp extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var STSwimmer
     */
    public $swimmer;

    /**
     * @var string
     */
    protected $theme = 'the_swim_team';

    /**
     * STSignUp constructor.
     * @param STSwimmer $swimmer
     */
    public function __construct(STSwimmer $swimmer)
    {
        $this->swimmer = $swimmer;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('North River Swim Team')
            ->with(['swimmer' => $this->swimmer])
            ->markdown('email.swim-team.sign_up');
    }
}
