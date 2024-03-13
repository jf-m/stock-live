<?php

namespace App\Console\Commands;

use App\Jobs\FetchLatestMarketValueJob;
use App\Models\Stock;
use Illuminate\Console\Command;

class FetchMarketValueCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'market:fetch
                            {symbol? : Filter on one single stock to fetch}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch latest market value from the stock exchange';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $symbol = $this->argument('symbol');
        $stock = null;
        if ($symbol) {
            $stock = Stock::where('symbol', $symbol)->first();
            if (! $stock) {
                $this->error(sprintf('Stock %s introuvable', $symbol));

                return Command::FAILURE;
            }
        }
        if ($symbol) {
            dispatch(new FetchLatestMarketValueJob($stock));
        } else {
            FetchLatestMarketValueJob::dispatchForCollectionOfStocks(Stock::all());
        }

        return Command::SUCCESS;
    }
}
