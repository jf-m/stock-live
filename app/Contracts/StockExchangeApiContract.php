<?php

namespace App\Contracts;

use App\Apis\DTO\MarketValueDTO;
use App\Exceptions\InvalidApiResponseException;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Collection;

interface StockExchangeApiContract
{
    /**
     * Fetch latest market values from a third party API
     *
     * @param string $symbol
     * @return Collection<int|string, MarketValueDTO>
     * @throws InvalidApiResponseException
     * @throws RequestException
     */
    public function fetchLatestMarketValues(string $symbol): Collection;
}
