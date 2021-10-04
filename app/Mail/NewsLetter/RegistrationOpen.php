<?php

namespace App\Mail\NewsLetter;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

//Test to people
//\Illuminate\Support\Facades\Mail::to('derek@deltavcreative.com')->send(new \App\Mail\NewsLetter\RegistrationOpen('derek@deltavcreative.com'));
//\Illuminate\Support\Facades\Mail::to('theswimschoolfl@gmail.com')->send(new \App\Mail\NewsLetter\RegistrationOpen('theswimschoolfl@gmail.com'));

//Send to everyone
//\App\Library\Marketing\Emails\Lessons\RegistrationOpenEmail::send();

class RegistrationOpen extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var
     */
    public $emailAddress;

    /**
     * Create a new message instance.
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
        return $this->markdown('email.newsletter.registrationOpen')
            ->from(config('mail.from.address'))
            ->subject('Weekday Group Swim Lessons & Swim Club Open for Registration!')
            ->with(['emailAddress' => $this->emailAddress])
            ->withSwiftMessage(function ($message) {
                $message->getHeaders()
                    ->addTextHeader('List-Unsubscribe', '<' . route('newsletter.unsubscribe', ['email' => $this->emailAddress]) . '>');
            });
    }
}
