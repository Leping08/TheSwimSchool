<?php

namespace App\Mail\Privates;

use App\PrivateLesson;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PrivateLessonSignUp extends Mailable
{
    use Queueable, SerializesModels;

    public $privateLesson;

    /**
     * Create a new message instance.
     *
     * @param  PrivateLesson  $privateLesson
     * @return void
     */
    public function __construct(PrivateLesson $privateLesson)
    {
        $this->privateLesson = $privateLesson->load('pool_sessions.location');
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $sorted_pool_sessions = $this->privateLesson->pool_sessions->sortBy('start');

        return $this->subject('Private Lesson with The Swim School')
            ->from(config('mail.from.address'))
            ->markdown('email.privates.sign_up')
            ->with([
                'stoted_pool_sessions' => $sorted_pool_sessions,
                'unique_locations' => $sorted_pool_sessions->pluck('location')->unique('id'),
            ]);
    }
}
