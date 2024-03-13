<?php

namespace App\Jobs;

use App\Contracts\StockExchangeServiceContract;
use App\Models\Stock;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Bus;

class FetchLatestMarketValueJob implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of times the job may be attempted.
     */
    public int $tries = 5;

    /**
     * The number of seconds to wait before retrying the job.
     */
    public int $backoff = 5;

    /**
     * Create a new job instance.
     */
    public function __construct(public Stock $stock)
    {
    }

    /**
     * Execute the job.
     */
    public function handle(StockExchangeServiceContract $exchangeServiceContract): void
    {
        $exchangeServiceContract->fetchAndStoreLatestMarketValuesOf($this->stock);
    }

    /**
     * @param  Collection<int, Stock>  $stocks
     *
     * @throws \Throwable
     */
    public static function dispatchForCollectionOfStocks(Collection $stocks): string
    {
        $batchJobs = [];
        foreach ($stocks as $stock) {
            $batchJobs[] = new self($stock);
        }
        $batch = Bus::batch($batchJobs)->dispatch();

        return $batch->id;
    }
}
