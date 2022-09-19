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
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
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
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
