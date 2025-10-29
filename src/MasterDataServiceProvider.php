<?php

namespace Iquesters\Masterdata;

use Illuminate\Support\ServiceProvider;
use Illuminate\Console\Command;
use Iquesters\Masterdata\Database\Seeders\MasterdataSeeder;
use Iquesters\Foundation\Support\ConfProvider;
use Iquesters\Foundation\Enums\Module as ModuleEnum;

class MasterDataServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // $this->mergeConfigFrom(__DIR__ . '/../config/masterdata.php', 'masterdata');

        // $this->registerSeedCommand();
        ConfProvider::register(ModuleEnum::MASTER_DATA, MasterDataConf::class);

        $this->registerSeedCommand();


    }

    public function boot(): void
    {
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'masterdata');

        if ($this->app->runningInConsole()) {
            $this->commands([
                'command.masterdata.seed'
            ]);
        }

        $this->publishes([
            __DIR__ . '/../config/masterdata.php' => config_path('masterdata.php'),
            __DIR__ . '/../resources/views/layouts/package.blade.php' => resource_path('views/vendor/masterdata/layouts/package.blade.php'),
        ], 'masterdata-config');
    }

    protected function registerSeedCommand(): void
    {
        $this->app->singleton('command.masterdata.seed', function ($app) {
            return new class extends Command {
                protected $signature = 'masterdata:seed';
                protected $description = 'Seed Masterdata module data';

                public function handle()
                {
                    $this->info('Running Masterdata Seeder...');
                    $seeder = new MasterdataSeeder();
                    $seeder->setCommand($this);
                    $seeder->run();
                    $this->info('Masterdata seeding completed!');
                    return 0;
                }
            };
        });
    }
}