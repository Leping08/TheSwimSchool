<?php

namespace App\Mail\Groups;

use App\Lesson;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SignUp extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var Lesson
     */
    public $lesson;

    /**
     * SignUp constructor.
     *
     * @param  Lesson  $lesson
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
            ->from(config('mail.from.address'))
            ->markdown('email.groups.lessonSignUp')
            ->with(['lesson' => $this->lesson]);
            // ->attach(asset('pdf/The_Swim_School_Policies_and_Procedures.pdf')); // @todo This is not working
    }
}
