<?php

namespace App\Contracts;

use App\Apis\DTO\MarketValueDTO;
use Illuminate\Support\Collection;

interface StockExchangeApiContract
{
    /**
     * @return Collection<int|string, MarketValueDTO>
     */
    public function fetchLatestMarketValues(string $symbol): Collection;
}
