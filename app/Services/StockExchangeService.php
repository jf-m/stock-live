<?php

namespace App\Services;

use App\Apis\DTO\MarketValueDTO;
use App\Contracts\StockExchangeApiContract;
use App\Contracts\StockExchangeServiceContract;
use App\Models\MarketValue;
use App\Models\Stock;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class StockExchangeService implements StockExchangeServiceContract
{
    public function __construct(protected StockExchangeApiContract $api)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function fetchAndStoreLatestMarketValuesOf(Stock $stock): void
    {
        $marketValues = $this->api->fetchLatestMarketValues($stock->symbol);
        $latestInterval = MarketValue::where('stock_id', $stock->id)->max('interval_time');
        if ($latestInterval) {
            $latestInterval = Carbon::parse($latestInterval);
            $marketValues = $marketValues->filter(fn (MarketValueDTO $marketValueDTO) => $marketValueDTO->timestamp > $latestInterval);
        }
        if ($marketValues->isNotEmpty()) {
            $this->bulkStoreMarketValueDtoCollection($stock, $marketValues);
            // A more recent market value has just been added to the DB so we can flush the cache.
            $stock->forgetLatestPriceCache();
        }
    }

    /**
     * Store in the database a collection of MarketValueDTO and attach it to $stock
     * This method can handle a large number of MarketValueDTO
     *
     * @param  Collection<string|int,MarketValueDTO>  $marketValueDtoCollection
     */
    protected function bulkStoreMarketValueDtoCollection(Stock $stock, Collection $marketValueDtoCollection): void
    {
        $marketValueDtoCollection
            ->chunk(50)->each(function (Collection $collection) use ($stock) {
                MarketValue::upsert($collection->map(fn (MarketValueDTO $marketValueDTO) => [
                    'stock_id' => $stock->id,
                    'open' => $marketValueDTO->open,
                    'high' => $marketValueDTO->high,
                    'low' => $marketValueDTO->low,
                    'close' => $marketValueDTO->close,
                    'volume' => $marketValueDTO->volume,
                    'interval_time' => $marketValueDTO->timestamp,
                ])->toArray(), [
                    'stock_id', 'interval_time',
                ]);
            });
    }
}
