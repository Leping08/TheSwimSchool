<?php

namespace App\Mail;

use App\Lesson;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

/**
 * Class WaitListAdmin
 * @package App\Mail
 */
class WaitListAdmin extends Mailable
{
    use Queueable, SerializesModels;


    /**
     * @var Lesson
     */
    public $lesson;


    /**
     * WaitListAdmin constructor.
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
            ->markdown('email.waitListAdmin')
            ->with(['lesson', $this->lesson]);
    }
}
