<?php

namespace App\Apis\AlphaVantage;

use App\Apis\BaseApi;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class AlphaVantageApi extends BaseApi
{
    public function fetchLatestMarketValues(string $symbol): Collection
    {
        $response = Http::get(config('services.alpha-vantage.url'), [
            'function' => 'TIME_SERIES_INTRADAY',
            'symbol' => $symbol,
            'interval' => '1min',
            'apikey' => config('services.alpha-vantage.key'),
            'outputsize' => 'compact',
        ]);
        $response->throwIf(! $response->successful());

        $json = AlphaVantageMarketValueValidator::validate($response->json());

        return AlphaVantageMarketValueMapper::map($json);
    }
}
