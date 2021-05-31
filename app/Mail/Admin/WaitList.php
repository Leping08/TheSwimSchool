<?php

namespace App\Mail\Admin;

use App\Lesson;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

/**
 * Class WaitList
 * @package App\Mail
 */
class WaitList extends Mailable
{
    use Queueable, SerializesModels;


    /**
     * @var Lesson
     */
    public $lesson;


    /**
     * WaitList constructor.
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
        return $this->subject('Wait List Filling Up')
            ->from(config('mail.from.address'))
            ->markdown('email.admin.waitListAdmin')
            ->with([
                'lesson' => $this->lesson,
                'waitListCount' => $this->lesson->waitlist()->count()
            ]);
    }
}
