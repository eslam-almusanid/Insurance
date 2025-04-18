<?php

namespace App\Providers;

use App\Integrations\Interfaces\NajmServiceInterface;
use App\Integrations\Interfaces\YakeenServiceInterface;
use App\Integrations\Services\Najm\NajmMockService;
use App\Integrations\Services\Najm\NajmService;
use App\Integrations\Services\Yakeen\YakeenMockService;
use App\Integrations\Services\Yakeen\YakeenService;
use Illuminate\Support\ServiceProvider;

class SingletonServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(NajmServiceInterface::class, function ($app) {
            // return new NajmService();
            return new NajmMockService();
        });

        $this->app->singleton(YakeenServiceInterface::class, function ($app) {
            // return new YakeenService();
            return new YakeenMockService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
