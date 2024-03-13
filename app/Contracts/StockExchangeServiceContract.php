<?php

namespace App\Contracts;

use App\Models\Stock;

interface StockExchangeServiceContract
{
    /**
     * Fetch the latest market values of the passed Stock.
     */
    public function fetchAndStoreLatestMarketValuesOf(Stock $stock): void;
}
