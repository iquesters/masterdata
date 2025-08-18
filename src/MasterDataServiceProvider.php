<?php

namespace Iquesters\Masterdata;

use Illuminate\Support\ServiceProvider;

class MasterDataServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/masterdata.php', 'masterdata');
    }

    public function boot(): void
    {
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'masterdata');

        $this->publishes([
            __DIR__ . '/../config/masterdata.php' => config_path('masterdata.php'),
            __DIR__ . '/../resources/views/layouts/package.blade.php' => resource_path('views/vendor/masterdata/layouts/package.blade.php'),
        ], 'masterdata-config');
    }
}