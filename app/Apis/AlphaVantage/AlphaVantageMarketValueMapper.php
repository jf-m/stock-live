<?php

namespace App\Apis\AlphaVantage;

use App\Apis\DTO\MarketValueDTO;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class AlphaVantageMarketValueMapper
{
    /**
     * @param  array<string, mixed>|null  $jsonResponse
     * @return Collection<int|string, MarketValueDTO>
     */
    public static function map(?array $jsonResponse): Collection
    {
        $list = collect();
        foreach ($jsonResponse['Time Series (1min)'] ?? [] as $timestamp => $rawMarketValue) {
            $marketValue = new MarketValueDTO(
                floatval($rawMarketValue['1. open']),
                floatval($rawMarketValue['2. high']),
                floatval($rawMarketValue['3. low']),
                floatval($rawMarketValue['4. close']),
                intval($rawMarketValue['5. volume']),
                Carbon::parse($timestamp));
            $list->add($marketValue);
        }

        return $list;
    }
}
