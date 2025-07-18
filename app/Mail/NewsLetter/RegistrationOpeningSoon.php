<?php

namespace App\Mail\NewsLetter;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

// Test to people
// \Illuminate\Support\Facades\Mail::to('derek@deltavcreative.com')->send(new \App\Mail\NewsLetter\RegistrationOpeningSoon('derek@deltavcreative.com'));
// \Illuminate\Support\Facades\Mail::to(config('contact.email.address'))->send(new \App\Mail\NewsLetter\RegistrationOpeningSoon(config('contact.email.address')));

// Send to everyone
// \App\Library\Marketing\Emails\Lessons\RegistrationOpeningSoonEmail::send();

class RegistrationOpeningSoon extends Mailable
{
    use Queueable, SerializesModels;

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
        return $this->markdown('email.newsletter.registrationOpeningSoon')
            ->from(config('mail.from.address'))
            ->subject('2021 Swim Season Is Almost Here!')
            ->with(['emailAddress' => $this->emailAddress])
            ->withSymfonyMessage(function ($message) {
                $message->getHeaders()
                    ->addTextHeader('List-Unsubscribe', '<'.route('newsletter.unsubscribe', ['email' => $this->emailAddress]).'>');
            });
    }
}
