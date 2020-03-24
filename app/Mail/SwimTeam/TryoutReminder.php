<?php

namespace App\Mail\SwimTeam;

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
     * @var string
     */
    public $theme = 'the_swim_team';

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
                    ->markdown('email.swim-team.tryoutReminder')
                    ->with([
                        'tryout' => $this->tryout,
                        'theme' => $this->theme
                    ]);
    }
}
