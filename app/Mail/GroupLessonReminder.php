<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class GroupLessonReminder extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var
     */
    public $lesson;

    /**
     * GroupLessonReminder constructor.
     * @param $lesson
     */
    public function __construct($lesson)
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
            ->markdown('email.groupLessonReminder')
            ->with(['lesson', $this->lesson]);
    }
}
