<?php

namespace App\Mail\Groups;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class GroupLessonReminder extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var
     */
    public $lesson;

    /**
     * GroupLessonReminder constructor.
     *
     * @param  $lesson
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
            ->from(config('mail.from.address'))
            ->markdown('email.groups.lessonReminder')
            ->with(['lesson' => $this->lesson]);
    }
}
