<?php

namespace App\Jobs;

use App\Mail\Privates\PrivatePoolSessionReminder;
use App\PoolSession;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendPrivatePoolSessionReminderEmails implements ShouldQueue
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
        Log::info('Starting to send private lesson pool session reminder emails.');
        $pool_sessions = PoolSession::startingTomorrow()->privateLessons()->with('lesson.swimmers')->get();

        if ($pool_sessions->isEmpty()) {
            Log::info('No pool sessions tomorrow. Not sending any emails.');

            return;
        }

        $pool_sessions->each(function ($pool_session) {
            $email = collect(data_get($pool_session, 'lesson.swimmers.*.email'))->first();
            try {
                Log::info("Sending group lesson reminder email to $email for pool_session ID: $pool_session->id");
                Mail::to($email)->send(new PrivatePoolSessionReminder($pool_session));
            } catch (\Exception $e) {
                Log::warning("Email error: $e");
            }
        });

        Log::info('Finished sending private lesson pool session reminder emails.');
    }
}
