<?php

namespace App\Providers;

use App\Nova\Metrics\LessonsPerSeason;
use App\Nova\Metrics\NewLessons;
use Laravel\Nova\Nova;
use Illuminate\Support\Facades\Gate;
use Laravel\Nova\NovaApplicationServiceProvider;
use App\Nova\Metrics\SwimmersPerDay;
use App\Nova\Metrics\NewSwimmers;
use App\Nova\Metrics\LessonsPerLevel;
use Leping\ParrishBullSharks\ParrishBullSharks;
use Tightenco\NovaStripe\NovaStripe;

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
            return in_array($user->email, config('auth.adminEmails'));
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
     * Get the extra dashboards that should be displayed on the Nova dashboard.
     *
     * @return array
     */
    protected function dashboards()
    {
        return [];
    }

    /**
     * Get the tools that should be listed in the Nova sidebar.
     *
     * @return array
     */
    public function tools()
    {
        return [
            new NovaStripe(),
            new ParrishBullSharks()
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
}
