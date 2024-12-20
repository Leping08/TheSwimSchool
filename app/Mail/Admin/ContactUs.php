<?php

namespace App\Mail\Admin;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

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
     *
     * @param  $data
     * @param  $subject
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
            ->from(config('mail.from.address'))
            ->markdown('email.admin.contactUs')
            ->with([
                'data' => $this->data,
                'subject' => $this->subject,
            ]);
    }
}
