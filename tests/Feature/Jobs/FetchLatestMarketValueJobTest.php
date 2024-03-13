<?php

namespace Tests\Feature\Jobs;

use App\Contracts\StockExchangeServiceContract;
use App\Jobs\FetchLatestMarketValueJob;
use App\Models\Stock;
use Tests\TestCase;

class FetchLatestMarketValueJobTest extends TestCase
{
    public function test_job_works(): void
    {
        $stock = Stock::factory()->create();
        $this->instance(
            StockExchangeServiceContract::class,
            \Mockery::mock(StockExchangeServiceContract::class)
                ->shouldReceive('fetchAndStoreLatestMarketValuesOf')
                ->once()
                ->getMock()
        );
        FetchLatestMarketValueJob::dispatch($stock);
    }
}
