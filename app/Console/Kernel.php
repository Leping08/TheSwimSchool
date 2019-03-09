<?php

namespace App\Console;

use App\Console\Commands\SendTryoutReminderEmails;
use App\Library\Facebook\FacebookApiRequest;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Console\Commands\SendReminderEmails;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        SendReminderEmails::class,
        SendTryoutReminderEmails::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command("send-lesson-reminder-emails")->dailyAt('8:00');
        $schedule->command("send-tryout-reminder-emails")->dailyAt('8:05');
        //Update reviews table with the SwimSchool Facebook page reviews
        $schedule->call(function () {
            (new FacebookApiRequest())->updateReviews();
        })->dailyAt('05:00');
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
