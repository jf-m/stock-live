<?php

namespace Tests\Feature\AlphaVantage;

use App\Apis\AlphaVantage\AlphaVantageApi;
use App\Exceptions\InvalidApiResponseException;
use Illuminate\Http\Client\Request;
use Tests\TestCase;

class AlphaVantageApiTest extends TestCase
{
    public function test_fetchLatestMarketValues_sends_right_request(): void
    {
        \Http::fake(function (Request $request) {
            $this->assertEquals(
                sprintf('%s?function=TIME_SERIES_INTRADAY&symbol=%s&interval=1min&apikey=%s&outputsize=compact', config('services.alpha-vantage.url'), 'IBM', config('services.alpha-vantage.key')),
                $request->url()
            );

            return \Http::response($this->getMockAlphaVantageData(), 200);
        });
        $api = new AlphaVantageApi();
        $data = $api->fetchLatestMarketValues('IBM');
    }

    public function test_fetchLatestMarketValues_map_json_response(): void
    {
        \Http::fake(fn (Request $request) => \Http::response($this->getMockAlphaVantageData(), 200));
        $api = new AlphaVantageApi();
        $data = $api->fetchLatestMarketValues('IBM');
        $this->assertEquals($data->count(), 3);
    }

    public function test_fetchLatestMarketValues_throws_invalid_exception_when_invalid_response(): void
    {
        \Http::fake(fn (Request $request) => \Http::response(['invalid' => 'response'], 200));
        $this->expectException(InvalidApiResponseException::class);

        $api = new AlphaVantageApi();
        $api->fetchLatestMarketValues('IBM');
    }

    public function test_fetchLatestMarketValues_throws_invalid_exception_when_invalid_json_response(): void
    {
        \Http::fake(fn (Request $request) => \Http::response('{invalid_;json;;', 200));
        $this->expectException(InvalidApiResponseException::class);

        $api = new AlphaVantageApi();
        $api->fetchLatestMarketValues('IBM');
    }
}
