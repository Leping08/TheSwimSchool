<?php

namespace App\Providers;

use App\Nova\Dashboards\Main;
use App\Nova\Metrics\LessonsPerLevel;
use App\Nova\Metrics\LessonsPerSeason;
use App\Nova\Metrics\NewLessons;
use App\Nova\Metrics\NewSwimmers;
use App\Nova\Metrics\SwimmersPerDay;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Laravel\Nova\Menu\Menu;
use Laravel\Nova\Menu\MenuItem;
use Laravel\Nova\Nova;
use Laravel\Nova\NovaApplicationServiceProvider;
use Leping\SwimTeamRoster\SwimTeamRoster;

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
        Nova::userMenu(function (Request $request, Menu $menu) {
            return $menu->append(MenuItem::externalLink('Email Blast', '/emails/newsletter'));
        });
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
        return [
            new Main(),
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
            new SwimTeamRoster(),
            // new \Tighten\NovaStripe\NovaStripe // bring back when css transparent button is fixed
            // new ParrishBullSharks()
            // new TailTool
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
