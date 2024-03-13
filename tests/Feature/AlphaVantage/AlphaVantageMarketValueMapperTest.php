<?php

namespace Tests\Feature\AlphaVantage;

use App\Apis\AlphaVantage\AlphaVantageMarketValueMapper;
use App\Apis\DTO\MarketValueDTO;
use Tests\TestCase;

class AlphaVantageMarketValueMapperTest extends TestCase
{
    public function test_it_can_create_market_value_DTO_from_response(): void
    {
        $market = AlphaVantageMarketValueMapper::map($this->getMockAlphaVantageData());
        $this->assertEquals(3, $market->count());
        $this->assertInstanceOf(MarketValueDTO::class, $market->first());
    }
}
