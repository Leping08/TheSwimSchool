<?php

namespace App\Mail\Admin;

use App\Lesson;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ClassFull extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var Lesson
     */
    public $lesson;

    /**
     * ClassFull constructor.
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
        return $this->subject($this->lesson->group->type.' lesson is full.')
            ->from(config('mail.from.address'))
            ->markdown('email.admin.classFull');
    }
}
