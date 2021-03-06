<?php


namespace App\Mail\NewsLetter;


use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

//Test to people
//\Illuminate\Support\Facades\Mail::to('derek@deltavcreative.com')->send(new \App\Mail\NewsLetter\Update('derek@deltavcreative.com'));
//\Illuminate\Support\Facades\Mail::to('theswimschoolfl@gmail.com')->send(new \App\Mail\NewsLetter\Update('theswimschoolfl@gmail.com'));

//Send to everyone
//\App\Library\Marketing\Emails\Events\UpdateEmail::send();


class Update extends Mailable
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
        return $this->subject('The Swim School is Moving!')
            ->from(config('mail.from.address'))
            ->markdown('email.newsletter.update')
            ->with(['emailAddress' => $this->emailAddress])
            ->withSwiftMessage(function ($message) {
                $message->getHeaders()
                    ->addTextHeader('List-Unsubscribe', '<' . route('newsletter.unsubscribe', ['email' => $this->emailAddress]) . '>');
            });
    }
}