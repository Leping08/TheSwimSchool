<?php

namespace App\Mail\Groups;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Lesson;

class SignUp extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var Lesson
     */
    public $lesson;


    /**
     * SignUp constructor.
     * @param Lesson $lesson
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
                    ->markdown('email.groups.lessonSignUp')
                    ->with(['lesson' => $this->lesson]);
    }
}
