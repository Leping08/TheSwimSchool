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
        return $this->subject('Private Lesson with The Swim School')
            ->markdown('email.privates.sign_up')
            ->with([
                'lesson' => $this->privateLesson,
                'first_pool_session' => $this->privateLesson->pool_sessions->sortBy('start')->frist(),
                'location' => $this->privateLesson->pool_sessions->sortBy('start')->frist()->location
            ]);
    }
}
