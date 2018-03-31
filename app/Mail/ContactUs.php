<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ContactUs extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var
     */
    public $data;
    /**
     * @var
     */
    public $subject;


    /**
     * ContactUs constructor.
     * @param $data
     * @param $subject
     */
    public function __construct($data, $subject)
    {
        $this->data = $data;
        $this->subject = $subject;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->subject)
                    ->markdown('email.contactUs')
                    ->with(['data', $this->data])
                    ->with(['subject', $this->subject]);
    }
}
