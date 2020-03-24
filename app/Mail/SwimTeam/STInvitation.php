<?php

namespace App\Mail\SwimTeam;

use App\Athlete;
use App\PromoCode;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

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
    protected $theme = 'the_swim_team';


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
        return $this->subject('North River Swim Team')
            ->markdown('email.swim-team.invitation')
            ->with([
                'athlete' => $this->athlete,
                'promoCode' => $this->promoCode
            ]);
    }
}
