<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Lesson;

class SignUp extends Mailable
{
    use Queueable, SerializesModels;

    public $lesson;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Lesson $lesson)
    {
        $this->lesson = $lesson;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->lesson->group->type)
                    ->markdown('email.lessonSignUp')
                    ->with(['lesson', $this->lesson]);
    }
}
