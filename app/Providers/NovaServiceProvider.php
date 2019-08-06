<?php

namespace App\Providers;

use App\Nova\Day;
use App\Nova\User;
use App\Nova\Level;
use App\Nova\Lesson;
use App\Nova\Season;
use App\Nova\Tryout;
use App\Nova\Athlete;
use App\Nova\STLevel;
use App\Nova\Swimmer;
use App\Nova\Location;
use App\Nova\STSeason;
use App\Nova\WaitList;
use Laravel\Nova\Nova;
use App\Nova\ContactUs;
use App\Nova\EmailList;
use App\Nova\STSwimmer;
use App\Nova\Testimonial;
use Laravel\Nova\Cards\Help;
use App\Nova\Metrics\NewLessons;
use App\Nova\Metrics\NewSwimmers;
use App\Nova\Metrics\NewEmailList;
use App\Nova\PrivateLessonRequest;
use App\Nova\Metrics\SwimmersPerDay;
use Illuminate\Support\Facades\Gate;
use Tightenco\NovaStripe\NovaStripe;
use App\Nova\Metrics\LessonsPerLevel;
use App\Nova\Metrics\LessonsPerSeason;
use App\Nova\Metrics\SubscribedEmails;
//use Spatie\TailTool\TailTool;
//use Tightenco\NovaStripe\NovaStripe;
use Leping\NorthRiverRapids\NorthRiverRapids;
use Laravel\Nova\NovaApplicationServiceProvider;
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
                'theswimschoolfl@gmail.com',
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
            new NorthRiverRapids,
            new NovaStripe(),
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
        Nova::resourcesIn(app_path('Nova'));
    }
}
