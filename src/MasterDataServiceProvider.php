<?php

namespace Iquesters\Masterdata;

use Illuminate\Support\ServiceProvider;

class MasterDataServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Merge config if you have one
        $this->mergeConfigFrom(__DIR__ . '/../config/masterdata.php', 'masterdata');
    }

    public function boot(): void
    {
        // Load routes, migrations, and views
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'masterdata');

        $this->publishes([
            __DIR__ . '/../config/masterdata.php' => config_path('masterdata.php'),
        ], 'config');
    }
}