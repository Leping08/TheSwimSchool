<?php

use App\Jobs\CreatePoolSessionAttendanceForDay;
use App\Jobs\SendGroupLessonsReminderEmails;
use App\Jobs\SendPrivatePoolSessionReminderEmails;
use App\Jobs\SendTryoutReminderEmails;
use Carbon\Carbon;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

// Artisan::command('inspire', function () {
//     $this->comment(Inspiring::quote());
// })->purpose('Display an inspiring quote');

// Queue a new job to create pool session attendance for the day
Schedule::call(function () {
    CreatePoolSessionAttendanceForDay::dispatchSync(Carbon::now());
})->dailyAt('3:00');

// Send group lesson reminder emails
Schedule::call(function () {
    SendGroupLessonsReminderEmails::dispatchSync();
})->dailyAt('7:10');

// Send Swim Team Tryout Reminder emails
Schedule::call(function () {
    SendTryoutReminderEmails::dispatchSync();
})->dailyAt('7:15');

// Send private pool session reminder emails
Schedule::call(function () {
    SendPrivatePoolSessionReminderEmails::dispatchSync();
})->dailyAt('7:20');

// Prune Telescope Table
Schedule::command('telescope:prune')->weekly();

// https://laravel.com/docs/10.x/upgrade#redis-cache-tags
Schedule::command('cache:prune-stale-tags')->hourly();
