<?php

namespace App\Mail\Privates;

use App\PoolSession;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PrivatePoolSessionReminder extends Mailable
{
    use Queueable, SerializesModels;

    public $pool_session;

    /**
     * Create a new message instance.
     *
     * @param  PoolSession  $pool_session
     */
    public function __construct(PoolSession $pool_session)
    {
        $this->pool_session = $pool_session;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Private Swim Lesson Reminder')
            ->from(config('mail.from.address'))
            ->markdown('email.privates.lesson_reminder')
            ->with([
                'pool_session' => $this->pool_session,
                'location' => $this->pool_session->location,
                'instructor' => $this->pool_session->instructor,
            ]);
    }
}
