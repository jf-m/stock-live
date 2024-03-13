<?php

namespace App\Contracts;

use App\Models\Stock;

interface StockExchangeServiceContract
{
    /**
     * Fetch the latest market values of the passed Stock.
     *
     * @param Stock $stock
     * @return void
     */
    public function fetchAndStoreLatestMarketValuesOf(Stock $stock): void;
}
