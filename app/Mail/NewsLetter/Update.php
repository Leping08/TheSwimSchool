<?php


namespace App\Mail\NewsLetter;


use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

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
        return $this->subject('2020 Summer Swim Team Update')
            ->from(config('mail.from.address'))
            ->markdown('email.newsletter.update')
            ->with(['emailAddress' => $this->emailAddress]);
    }
}