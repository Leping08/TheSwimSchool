<?php

namespace App\Mail\Admin;

use App\PrivateLessonLead;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PrivateLessonLeadEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var PrivateLessonLeadEmail
     */
    public $privateLessonLead;

    /**
     * PrivateLessonLeadEmail constructor.
     *
     * @param  PrivateLessonLead  $privateLessonLead
     */
    public function __construct(PrivateLessonLead $privateLessonLead)
    {
        $this->privateLessonLead = $privateLessonLead;
    }

    /**
     * @return $this
     */
    public function build()
    {
        return $this->subject('Private Lesson Request')
            ->from(config('mail.from.address'))
            ->markdown('email.admin.privateLessonLead')
            ->with(['lead' => $this->privateLessonLead]);
    }
}
