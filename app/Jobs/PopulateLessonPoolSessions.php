<?php

namespace App\Jobs;

use App\Lesson;
use App\PoolSession;
use App\PrivateLesson;
use App\PrivatePoolSession;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class PopulateLessonPoolSessions implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Loop through each lesson
        foreach (Lesson::all() as $lesson) {
            /** @var Lesson $lesson */
            $lesson->generatePoolSessions([]);
        }


        // Loop through each private pool session
        foreach (PrivatePoolSession::all() as $privatePoolSession) {
            /** @var PrivatePoolSession $privatePoolSession */

            // Create the pool session
            PoolSession::firstOrCreate([
                'start' => $privatePoolSession->start,
                'end' => $privatePoolSession->end,
                'location_id' => $privatePoolSession->location_id,
                'instructor_id' => $privatePoolSession->instructor_id,
                'pool_session_id' => $privatePoolSession->private_lesson_id,
                'pool_session_type' => PrivateLesson::class,
            ]);
        }
    }
}
