<?php

namespace Tests\Feature\Api;

use App\Models\MarketValue;
use App\Models\Stock;
use Tests\TestCase;

class StockPriceApiControllerTest extends TestCase
{
    private Stock $stock;

    public function setUp(): void
    {
        parent::setUp();
        $this->stock = Stock::factory()
            ->has(MarketValue::factory()->count(3))->create();
    }

    public function test_getLatestPrice_returns_price(): void
    {
        $response = $this->getJson(sprintf('/api/stock/%s/price/latest', $this->stock->symbol));
        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'open',
                'high',
                'low',
                'close',
                'volume',
                'interval_time',
                'percentage_change',
            ]);

    }

    public function test_getLatestPrice_hits_cache(): void
    {
        \Cache::shouldReceive('remember')
            ->once()
            ->withSomeOfArgs($this->stock->getLatestPriceCacheKeyName());
        $this->get(sprintf('/api/stock/%s/price/latest', $this->stock->symbol));
    }

    public function test_getLatestPrice_returns_error_when_symbol_missing(): void
    {
        $response = $this->getJson('/api/stock/MISSING/price/latest');
        $response
            ->assertStatus(404);
    }

    public function test_getLatestPrice_returns_error_when_no_data(): void
    {
        Stock::factory()->create([
            'symbol' => 'newstock',
        ]);
        $response = $this->getJson('/api/stock/newstock/price/latest');
        $response
            ->assertStatus(404);
    }
}
