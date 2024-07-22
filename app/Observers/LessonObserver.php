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
        /**
         * Make sure if the lesson gets updated and the location is changed
         * the pool sessions locations are updated to the new location as well.
         */
        $lesson?->pool_sessions?->each(function ($poolSession) use ($lesson) {
            if ($poolSession->location_id === $lesson->location_id) {
                return; // Do nothing the location is the same
            }

            $poolSession->update([
                'location_id' => $lesson->location_id,
            ]);
        });
    }

    /**
     * Handle the lesson "deleted" event.
     *
     * @param  \App\Lesson  $lesson
     * @return void
     */
    public function deleted(Lesson $lesson)
    {
        /**
         * Remove all the pool sessions related to this lesson.
         * This fixes a problem with instructor calendar not loading
         * when the lesson is deleted but the pool sessions still exists.
         */
        $lesson->pool_sessions->each->delete();
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
