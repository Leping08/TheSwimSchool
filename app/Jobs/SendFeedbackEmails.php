<?php

namespace App\Jobs;

use App\Models\Lesson;
use App\Mail\FeedbackSurvey;
use App\Mail\TryoutReminder;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendFeedbackEmails implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $lessons = Lesson::with('swimmers')->endedOneWeekAgo()->get();

        if (count($lessons)) {

            //Collect all the swimmers
            $swimmers = collect();
            foreach ($lessons as $lesson) {
                foreach ($lesson->swimmers as $swimmer) {
                    $swimmers->push($swimmer);
                }
            }

            //Only get swimmers with unique emails
            $uniqueSwimmers = $swimmers->unique('email');

            //Email the feedback surveys to the unique emails
            foreach ($uniqueSwimmers as $swimmer) {
                if ($swimmer->email) {
                    try {
                        Log::info("Sending feedback survey email to $swimmer->email for swimmer ID: $swimmer->id");
                        Mail::to($swimmer->email)->send(new FeedbackSurvey());
                    } catch (\Exception $e) {
                        Log::warning("Email error: $e");
                    }
                }
            }
        } else {
            Log::info('No lessons ended a week ago.');
        }
    }
}
