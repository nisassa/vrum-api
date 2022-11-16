<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class CurrentTimeServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        // Get current time
        $now = Carbon::now();

        if ($this->app->runningInConsole() === false) {
            // Share current date time with all views
            View::share('now', $now);
        }

        // This can be shared even if app is running in console as it is used e.g. by DatabaseSeeder
        config(['app.now' => $now]);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        // Register current time singleton
        $this->app->singleton('now', function ($app) {
            return Carbon::now();
        });
    }
}
