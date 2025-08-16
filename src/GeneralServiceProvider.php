<?php

namespace Carlxaeron\General;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class GeneralServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Register the package
        $this->mergeConfigFrom(
            __DIR__.'/../config/general.php', 'general'
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Publish config file
        $this->publishes([
            __DIR__.'/../config/general.php' => config_path('general.php'),
        ], 'general-config');

        // Publish migrations
        $this->publishes([
            __DIR__.'/../database/migrations' => database_path('migrations'),
        ], 'general-migrations');

        // Load migrations
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        // Load helpers
        if (file_exists(__DIR__.'/helpers.php')) {
            require_once __DIR__.'/helpers.php';
        }
    }
}

