<?php

namespace App\Observers;

use App\Athlete;
use App\Library\Helpers\RandomString;

class AthleteObserver
{
    /**
     * Handle the athlete "created" event.
     *
     * @param  \App\Athlete  $athlete
     * @return void
     */
    public function created(Athlete $athlete)
    {
        $athlete->hash = RandomString::generate(); // todo update this to the laravel uuid
        $athlete->save();
    }

    /**
     * Handle the athlete "updated" event.
     *
     * @param  \App\Athlete  $athlete
     * @return void
     */
    public function updated(Athlete $athlete)
    {
        //
    }

    /**
     * Handle the athlete "deleted" event.
     *
     * @param  \App\Athlete  $athlete
     * @return void
     */
    public function deleted(Athlete $athlete)
    {
        //
    }

    /**
     * Handle the athlete "restored" event.
     *
     * @param  \App\Athlete  $athlete
     * @return void
     */
    public function restored(Athlete $athlete)
    {
        //
    }

    /**
     * Handle the athlete "force deleted" event.
     *
     * @param  \App\Athlete  $athlete
     * @return void
     */
    public function forceDeleted(Athlete $athlete)
    {
        //
    }
}
