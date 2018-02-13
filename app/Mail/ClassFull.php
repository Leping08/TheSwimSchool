<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Lesson;

class ClassFull extends Mailable
{
    use Queueable, SerializesModels;

    public $lesson;

    /**
     * Create a new message instance.
     *
     * @param \App\Lesson $lesson
     * @return $this
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
                    ->markdown('email.classFull');
    }
}
