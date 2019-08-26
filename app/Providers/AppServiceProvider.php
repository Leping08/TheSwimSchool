<?php

namespace App\Providers;

use App\Athlete;
use App\Lesson;
use App\Observers\AthleteObserver;
use App\Observers\LessonObserver;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        Lesson::observe(LessonObserver::class);
        Athlete::observe(AthleteObserver::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
