<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Lesson;

class LessonSignUp extends Mailable
{
    use Queueable, SerializesModels;

    protected $lesson;

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
        //$lesson = Lesson::findOrFail($this->lesson_id);
        //return $this->markdown('email.lessonSignUp')
                    //->with(['lesson', $this->lesson]);
        return $this->markdown('email.lessonSignUp');
    }
}
