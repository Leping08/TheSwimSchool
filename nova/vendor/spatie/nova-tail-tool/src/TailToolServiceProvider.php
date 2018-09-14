<?php

namespace Spatie\TailTool;

use Laravel\Nova\Nova;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Spatie\TailTool\Http\Middleware\Authorize;

class TailToolServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'TailTool');

        $this->app->booted(function () {
            $this->routes();
        });
    }

    protected function routes()
    {
        if ($this->app->routesAreCached()) {
            return;
        }

        Route::middleware(['nova', Authorize::class])
            ->prefix('/nova-vendor/spatie/tail-tool')
            ->group(
                __DIR__.'/../routes/api.php'
            );
    }
}
