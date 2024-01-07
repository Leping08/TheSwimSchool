<?php

namespace App\Observers;

use App\Lesson;
use Illuminate\Support\Facades\Log;

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
        $days = collect($lesson->days)->filter(function ($day) {
            return $day === true;
        })->keys();

        if ($days->count() > 0) {
            Log::info("Setting the days of the week for lesson id {$lesson->id}.");
            $lesson->DaysOfTheWeek()->sync($days->toArray());
        }
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
