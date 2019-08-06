<?php

namespace App\Mail;

use App\Models\Athlete;
use App\Models\PromoCode;
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
            ->with(['athlete', $this->athlete], ['promoCode', $this->promoCode])
            ->markdown('email.STInvitation');
    }
}
