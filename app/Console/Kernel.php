<?php

namespace App\Console;

use App\Jobs\SendGroupLessonsReminderEmails;
use App\Jobs\SendPrivatePoolSessionReminderEmails;
use App\Jobs\SendTryoutReminderEmails;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        //Send group lesson reminder emails
        $schedule->call(function () {
            SendGroupLessonsReminderEmails::dispatchSync();
        })->dailyAt('7:10');

        //Send Swim Team Tryout Reminder emails
        $schedule->call(function () {
            SendTryoutReminderEmails::dispatchSync();
        })->dailyAt('7:15');

        //Send private pool session reminder emails
        $schedule->call(function () {
            SendPrivatePoolSessionReminderEmails::dispatchSync();
        })->dailyAt('7:20');

        //Prune Telescope Table
        $schedule->command('telescope:prune')->weekly();

        // https://laravel.com/docs/10.x/upgrade#redis-cache-tags
        $schedule->command('cache:prune-stale-tags')->hourly();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
