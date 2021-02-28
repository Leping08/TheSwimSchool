<?php

namespace App\Mail\Privates;

use App\PrivateLesson;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PrivateLessonSignUp extends Mailable
{
    use Queueable, SerializesModels;

    public $privateLesson;

    /**
     * Create a new message instance.
     *
     * @return void
     * @param PrivateLesson $privateLesson
     */
    public function __construct(PrivateLesson $privateLesson)
    {
        $this->privateLesson = $privateLesson;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $firstPoolSession = collect($this->privateLesson->pool_sessions->sortBy('start'))->first();

        return $this->subject('Private Lesson with The Swim School')
            ->from(config('mail.from.address'))
            ->markdown('email.privates.sign_up')
            ->with([
                'lesson' => $this->privateLesson,
                'pool_sessions' => $this->privateLesson->pool_sessions,
                'first_pool_session' => $firstPoolSession,
                'location' => $firstPoolSession->location,
                'instructor' => $firstPoolSession->instructor
            ]);
    }
}
