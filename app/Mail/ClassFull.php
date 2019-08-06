<?php

namespace App\Mail;

use App\Models\Lesson;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ClassFull extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var Lesson
     */
    public $lesson;

    /**
     * ClassFull constructor.
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
        return $this->subject($this->lesson->group->type.' lesson is full.')
                    ->markdown('email.classFull');
    }
}
