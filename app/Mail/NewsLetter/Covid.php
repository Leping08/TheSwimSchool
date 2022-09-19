<?php

namespace App\Mail\NewsLetter;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

//Test to people
//\Illuminate\Support\Facades\Mail::to('derek@deltavcreative.com')->send(new \App\Mail\NewsLetter\Covid('derek@deltavcreative.com'));
//\Illuminate\Support\Facades\Mail::to('theswimschoolfl@gmail.com')->send(new \App\Mail\NewsLetter\Covid('theswimschoolfl@gmail.com'));

//Send to everyone
//(new \App\Library\Marketing\Emails\Events\Covid())->send();

class Covid extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var
     */
    public $emailAddress;

    /**
     * Create a new message instance.
     *
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
        return $this->markdown('email.newsletter.covid')
            ->from(config('mail.from.address'))
            ->subject('COVID-19 Safety Precautions')
            ->with(['emailAddress' => $this->emailAddress])
            ->withSymfonyMessage(function ($message) {
                $message->getHeaders()
                    ->addTextHeader('List-Unsubscribe', '<'.route('newsletter.unsubscribe', ['email' => $this->emailAddress]).'>');
            });
    }
}
