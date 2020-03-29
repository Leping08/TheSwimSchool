<?php

namespace App\Mail\Privates;

use App\PrivatePoolSession;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PrivatePoolSessionReminder extends Mailable
{
    use Queueable, SerializesModels;

    public $pool_session;

    /**
     * Create a new message instance.
     * @param  PrivatePoolSession  $pool_session
     */
    public function __construct(PrivatePoolSession $pool_session)
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
            ->markdown('email.privates.lesson_reminder')
            ->with([
                'pool_session' => $this->pool_session,
                'location' => $this->pool_session->location
            ]);
    }
}
