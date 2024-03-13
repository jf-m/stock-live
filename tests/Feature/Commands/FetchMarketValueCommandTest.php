<?php

namespace Tests\Feature\Commands;

use App\Jobs\FetchLatestMarketValueJob;
use App\Models\Stock;
use Illuminate\Console\Command;
use Tests\TestCase;

class FetchMarketValueCommandTest extends TestCase
{
    public function test_command_single_stock_latest_works(): void
    {
        Stock::factory()->create(['symbol' => 'AAPL']);
        Stock::factory()->create(['symbol' => 'IBM']);
        \Queue::fake();
        $this->artisan('market:fetch AAPL');
        \Queue::assertPushed(FetchLatestMarketValueJob::class);
        \Queue::assertCount(1);
    }

    public function test_command_all_stock_latest_works(): void
    {
        Stock::factory()->create(['symbol' => 'AAPL']);
        Stock::factory()->create(['symbol' => 'IBM']);
        \Queue::fake();
        $this->artisan('market:fetch');
        \Queue::assertPushed(FetchLatestMarketValueJob::class);
        \Queue::assertCount(2);
    }

    public function test_command_unknown_stock(): void
    {
        \Queue::fake();
        $this->artisan('market:fetch AAPL')->assertExitCode(Command::FAILURE);
        \Queue::assertNothingPushed();
    }
}
