<?php

namespace App\Providers;

use App\Nova\EmailList;
use App\Nova\Lesson;
use App\Nova\Level;
use App\Nova\Location;
use App\Nova\Metrics\LessonsPerSeason;
use App\Nova\Metrics\NewEmailList;
use App\Nova\Metrics\NewLessons;
use App\Nova\Metrics\SubscribedEmails;
use App\Nova\PrivateLessonRequest;
use App\Nova\Season;
use App\Nova\Swimmer;
use App\Nova\User;
use Laravel\Nova\Nova;
use Laravel\Nova\Cards\Help;
use Illuminate\Support\Facades\Gate;
use Laravel\Nova\NovaApplicationServiceProvider;
use App\Nova\Metrics\SwimmersPerDay;
use App\Nova\Metrics\NewSwimmers;
use App\Nova\Metrics\LessonsPerLevel;
use Spatie\TailTool\TailTool;
use Tightenco\NovaStripe\NovaStripe;
use Gregoriohc\LaravelNovaThemeResponsive\ThemeServiceProvider;

class NovaServiceProvider extends NovaApplicationServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }

    /**
     * Register the Nova routes.
     *
     * @return void
     */
    protected function routes()
    {
        Nova::routes()
                ->withAuthenticationRoutes()
                ->withPasswordResetRoutes()
                ->register();
    }

    /**
     * Register the Nova gate.
     *
     * This gate determines who can access Nova in non-local environments.
     *
     * @return void
     */
    protected function gate()
    {
        Gate::define('viewNova', function ($user) {
            return in_array($user->email, [
                'derek@deltavcreative.com',
                'theswimschoolfl@gmail.com'
            ]);
        });
    }

    /**
     * Get the cards that should be displayed on the Nova dashboard.
     *
     * @return array
     */
    protected function cards()
    {
        return [
            (new SwimmersPerDay)->width('2/3'),
            (new NewSwimmers)->width('1/3'),
            (new NewLessons)->width('1/3'),
            (new LessonsPerLevel)->width('2/3'),
            (new LessonsPerSeason)->width('2/3'),
            //(new NewEmailList)->width('1/3'),
            //(new SubscribedEmails)->width('1/3'),
            //new Help,
        ];
    }

    /**
     * Get the tools that should be listed in the Nova sidebar.
     *
     * @return array
     */
    public function tools()
    {
        return [
            new NovaStripe,
            //new TailTool
        ];
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

    /**
     * Register the application's Nova resources.
     *
     * @return void
     */
    protected function resources()
    {

        Nova::resources([
            Swimmer::class,
            Lesson::class,
            Season::class,
            Location::class,
            Level::class,
            EmailList::class,
            PrivateLessonRequest::class,
            User::class,
        ]);
        //Nova::resourcesIn(app_path('Nova'));
    }
}