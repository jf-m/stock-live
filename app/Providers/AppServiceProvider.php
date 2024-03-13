<?php

namespace App\Providers;

use App\Apis\AlphaVantage\AlphaVantageApi;
use App\Contracts\StockExchangeApiContract;
use App\Contracts\StockExchangeServiceContract;
use App\Services\StockExchangeService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {

        $this->app->bind(StockExchangeApiContract::class, AlphaVantageApi::class);
        $this->app->bind(StockExchangeServiceContract::class, StockExchangeService::class);

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
