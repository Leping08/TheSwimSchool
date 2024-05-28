<?php

namespace App\Observers;

use App\Lesson;

class LessonObserver
{
    /**
     * Handle the lesson "created" event.
     *
     * @param  \App\Lesson  $lesson
     * @return void
     */
    public function created(Lesson $lesson)
    {
        $lesson->generatePoolSessions([]);
    }

    /**
     * Handle the lesson "updated" event.
     *
     * @param  \App\Lesson  $lesson
     * @return void
     */
    public function updated(Lesson $lesson)
    {
        //
    }

    /**
     * Handle the lesson "deleted" event.
     *
     * @param  \App\Lesson  $lesson
     * @return void
     */
    public function deleted(Lesson $lesson)
    {
        //
    }

    /**
     * Handle the lesson "restored" event.
     *
     * @param  \App\Lesson  $lesson
     * @return void
     */
    public function restored(Lesson $lesson)
    {
        //
    }

    /**
     * Handle the lesson "force deleted" event.
     *
     * @param  \App\Lesson  $lesson
     * @return void
     */
    public function forceDeleted(Lesson $lesson)
    {
        //
    }
}
