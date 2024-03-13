<?php

namespace Tests\Feature\Services;

use App\Apis\DTO\MarketValueDTO;
use App\Contracts\StockExchangeApiContract;
use App\Models\MarketValue;
use App\Models\Stock;
use App\Services\StockExchangeService;
use Carbon\Carbon;
use Tests\TestCase;

class StockExchangeServiceTest extends TestCase
{
    public function test_fetchAndStoreLatestMarketValuesOf_works(): void
    {
        $stock = Stock::factory()->create();
        $apiMock = $this->mock(StockExchangeApiContract::class)
            ->expects('fetchLatestMarketValues')
            ->andReturn(
                collect([
                    new MarketValueDTO(10, 1, 1, 1, 1, Carbon::now()),
                    new MarketValueDTO(20, 1, 1, 1, 1, Carbon::now()->subMinute()),
                ])
            )->getMock();
        $service = new StockExchangeService($apiMock);
        $service->fetchAndStoreLatestMarketValuesOf($stock);
        $this->assertDatabaseCount(MarketValue::class, 2);
        $this->assertDatabaseHas(MarketValue::class, [
            'open' => 10,
            'stock_id' => $stock->id,
        ]);
        $this->assertDatabaseHas(MarketValue::class, [
            'open' => 20,
            'stock_id' => $stock->id,
        ]);
    }

    public function test_fetchAndStoreLatestMarketValuesOf_store_only_latest_values(): void
    {
        $stock = Stock::factory()
            ->has(MarketValue::factory()->count(1)
                ->state(function (array $attributes) {
                    return ['interval_time' => Carbon::now()->subMinutes(2)];
                }))
            ->create();
        $apiMock = $this->mock(StockExchangeApiContract::class)
            ->expects('fetchLatestMarketValues')
            ->andReturn(
                collect([
                    new MarketValueDTO(10, 1, 1, 1, 1, Carbon::now()),
                    new MarketValueDTO(20, 1, 1, 1, 1, Carbon::now()->subMinutes(1)),
                    new MarketValueDTO(20, 1, 1, 1, 1, Carbon::now()->subMinutes(2)),
                    new MarketValueDTO(20, 1, 1, 1, 1, Carbon::now()->subMinutes(3)),
                    new MarketValueDTO(20, 1, 1, 1, 1, Carbon::now()->subMinutes(4)),
                ])
            )->getMock();
        $service = new StockExchangeService($apiMock);
        $service->fetchAndStoreLatestMarketValuesOf($stock);
        $this->assertDatabaseCount(MarketValue::class, 3);
    }

    public function test_fetchAndStoreLatestMarketValuesOf_does_clears_cache(): void
    {
        $stock = Stock::factory()->create();
        $apiMock = $this->mock(StockExchangeApiContract::class)
            ->expects('fetchLatestMarketValues')
            ->andReturn(
                collect([
                    new MarketValueDTO(10, 1, 1, 1, 1, Carbon::now()),
                ])
            )->getMock();

        \Cache::shouldReceive('forget')->once()->with($stock->getLatestPriceCacheKeyName());
        $service = new StockExchangeService($apiMock);
        $service->fetchAndStoreLatestMarketValuesOf($stock);
    }
}
