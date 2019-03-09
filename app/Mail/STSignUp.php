<?php

namespace App\Mail;

use App\Models\STSwimmer;
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
            ->with(['swimmer', $this->swimmer])
            ->markdown('email.STSignUp');
    }
}
