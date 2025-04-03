<?php

namespace App\Providers;

use App\Interfaces\NajmServiceInterface;
use App\Interfaces\YakeenServiceInterface;
use App\Services\V1\Integrations\NajmMockService;
use App\Services\V1\Integrations\NajmService;
use App\Services\V1\Integrations\YakeenMockService;
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
