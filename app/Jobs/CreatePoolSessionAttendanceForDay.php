<?php

namespace App\Jobs;

use App\PoolSession;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CreatePoolSessionAttendanceForDay implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The date to create the pool session attendance for.
     *
     * @var string
     */
    protected Carbon $date;

    /**
     * Create a new job instance.
     */
    public function __construct(Carbon $date)
    {
        $this->date = $date;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Get all the pool sessions for the day
        $poolSessions = PoolSession::whereDate('start', $this->date)->get();

        // Loop through each pool session and create the attendance
        $poolSessions->each(function ($poolSession) {
            $poolSession->lesson->swimmers->each(function ($swimmer) use ($poolSession) {
                $poolSession->attendances()->firstOrCreate([
                    'pool_session_id' => $poolSession->id,
                    'swimmable_id' => $swimmer->id,
                    'swimmable_type' => get_class($swimmer),
                    'attended' => false,
                ]);
            });
        });
    }
}
