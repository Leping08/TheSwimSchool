<?php

namespace App\Mail;

use App\Lesson;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class LessonLink extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var Lesson
     */
    public $lesson;

    /**
     * LessonLink constructor.
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
        return $this->subject('Lesson Signup')
            ->markdown('email.lessonLink')
            ->with(['lesson', $this->lesson]);
    }
}
