<?php

namespace App\Console;

use App\Jobs\SendFeedbackEmails;
use App\Jobs\SendGroupLessonsReminderEmails;
use App\Jobs\SendPrivatePoolSessionReminderEmails;
use App\Jobs\SendTryoutReminderEmails;
use App\Library\Facebook\FacebookApiRequest;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        //Send feedback email survey
//        $schedule->call(function (){
//            SendFeedbackEmails::dispatchNow();
//        })->dailyAt('7:00');

        //Update reviews table with the SwimSchool Facebook page reviews
//        $schedule->call(function () {
//            (new FacebookApiRequest())->updateReviews();
//        })->dailyAt('7:05');

        //Send group lesson reminder emails
        $schedule->call(function () {
            SendGroupLessonsReminderEmails::dispatchNow();
        })->dailyAt('7:10');

        //Send Swim Team Tryout Reminder emails
        $schedule->call(function () {
            SendTryoutReminderEmails::dispatchNow();
        })->dailyAt('7:15');

        //Send private pool session reminder emails
        $schedule->call(function () {
            SendPrivatePoolSessionReminderEmails::dispatchNow();
        })->dailyAt('7:20');

        //Prune Telescope Table
        $schedule->command('telescope:prune')->daily();
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
