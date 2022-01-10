<?php

namespace App\Mail\NewsLetter;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Custom extends Mailable
{
    use Queueable, SerializesModels;

    protected $email_address;
    protected $email_subject;
    protected $body;
    protected $image_url;
    protected $button_url;
    protected $button_text;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(string $email_address, string $email_subject, string $body, string $image_url, string $button_url, string $button_text)
    {
        $this->email_address = $email_address;
        $this->email_subject = $email_subject;
        $this->body = $body;
        $this->image_url = $image_url;
        $this->button_url = $button_url;
        $this->button_text = $button_text;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('email.newsletter.testing')
                    ->from(config('mail.from.address'))
                    ->subject($this->email_subject)
                    ->with([
                        'emailAddress' => $this->email_address,
                        'button_text' => $this->button_text,
                        'button_url' => $this->button_url,
                        'image_url' => $this->image_url,
                        'body' => $this->body,
                    ])
                    ->withSwiftMessage(function ($message) {
                        $message->getHeaders()
                            ->addTextHeader('List-Unsubscribe', '<' . route('newsletter.unsubscribe', ['email' => $this->email_address]) . '>');
                    });
    }
}
