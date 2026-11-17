<?php

namespace ITMOSOFT\Tenders;

use Illuminate\Support\ServiceProvider;

class TendersServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/tenders.php', 'itmosoft-tenders');
    }

    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/../config/tenders.php' => config_path('tenders.php'),
        ], 'tenders-config');
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
    }
}
