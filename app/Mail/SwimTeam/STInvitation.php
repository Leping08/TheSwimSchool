<?php

namespace App\Mail\SwimTeam;

use App\Athlete;
use App\PromoCode;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

//\Illuminate\Support\Facades\Mail::to('derek@deltavcreative.com')->send(new \App\Mail\SwimTeam\STInvitation(\App\Athlete::find(371)));
//\Illuminate\Support\Facades\Mail::to('theswimschoolfl@gmail.com')->send(new \App\Mail\SwimTeam\STInvitation(\App\Athlete::find(371)));

class STInvitation extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var Athlete
     */
    public $athlete;

    /**
     * @var PromoCode
     */
    public $promoCode;

    /**
     * @var string
     */
    public $theme = 'the_swim_team';


    /**
     * STInvitation constructor.
     * @param Athlete $athlete
     * @param PromoCode $promoCode
     */
    public function __construct(Athlete $athlete, PromoCode $promoCode = null)
    {
        $this->athlete = $athlete;
        $this->promoCode = $promoCode;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject(config('swim-team.full-name'))
            ->from(config('mail.from.address'))
            ->markdown('email.swim-team.invitation')
            ->with([
                'athlete' => $this->athlete,
                'promoCode' => $this->promoCode
            ]);
    }
}
