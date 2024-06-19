<?php

namespace App\Mail\SwimTeam;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

//Test to people
//\Illuminate\Support\Facades\Mail::to('derek@deltavcreative.com')->send(new \App\Mail\SwimTeam\TryoutsOpen('derek@deltavcreative.com'));
//\Illuminate\Support\Facades\Mail::to(config('contact.email.address'))->send(new \App\Mail\SwimTeam\TryoutsOpen(config('contact.email.address')));

//Send to everyone
//\App\Library\Marketing\Emails\SwimTeam\TryoutRegistrationOpen::send(\App\STSeason::find(5));

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
     *
     * @param  $emailAddress
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
        return $this->subject('2021 Swim Team Tryouts are Now Open for Sign Up!')
            ->from(config('mail.from.address'))
            ->markdown('email.swim-team.tryoutsOpen')
            ->with(['emailAddress' => $this->emailAddress]);
    }
}
