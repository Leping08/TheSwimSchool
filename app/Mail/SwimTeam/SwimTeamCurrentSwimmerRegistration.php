<?php

namespace App\Mail\SwimTeam;

use App\STSwimmer;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SwimTeamCurrentSwimmerRegistration extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var STSwimmer
     */
    public $swimmer;

    /**
     * @var string
     */
    public $theme = 'the_swim_team';

    /**
     * STSignUp constructor.
     *
     * @param  STSwimmer  $swimmer
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
        return $this->subject('Year Round Swim Team Registration Is Open!')
            ->from(config('mail.from.address'))
            ->with(['swimmer' => $this->swimmer])
            ->markdown('email.swim-team.current-swimmer-registration');
    }
}
