<?php

namespace Tests\Feature\Transformers;

use App\Http\Transformers\MarketValueTransformer;
use App\Models\MarketValue;
use App\Models\Stock;
use Tests\TestCase;

class MarketValueTransformerTest extends TestCase
{
    public function test_market_value_transform_works(): void
    {
        $marketValue = MarketValue::factory()->for(Stock::factory()->make())->make([
            'open' => 100,
            'high' => 6144,
            'low' => 23,
            'close' => 101,
            'volume' => 1,
            'interval_time' => '2004-05-18 00:00:00',
        ]);

        $json = (new MarketValueTransformer())->transform($marketValue);
        $this->assertEquals(100, $json['open']);
        $this->assertEquals(6144, $json['high']);
        $this->assertEquals(23, $json['low']);
        $this->assertEquals(101, $json['close']);
        $this->assertEquals(1, $json['volume']);
        $this->assertEquals(1, $json['percentage_change']);
    }

    public function test_market_value_transform_collection_works(): void
    {
        $marketValue1 = MarketValue::factory()->for(Stock::factory()->make())->make([
            'open' => 100,
            'high' => 6144,
            'low' => 23,
            'close' => 101,
            'volume' => 1,
            'interval_time' => '2004-05-18 00:00:00',
        ]);
        $marketValue2 = MarketValue::factory()->for(Stock::factory()->make())->make([
            'open' => 200,
            'high' => 144,
            'low' => 3,
            'close' => 10,
            'volume' => 1,
            'interval_time' => '2004-05-18 00:00:00',
        ]);

        $json = (new MarketValueTransformer())->transformCollection(collect([$marketValue1, $marketValue2]));
        $this->assertCount(2, $json);
        $this->assertEquals(100, $json[0]['open']);
        $this->assertEquals(6144, $json[0]['high']);
        $this->assertEquals(23, $json[0]['low']);
        $this->assertEquals(101, $json[0]['close']);
        $this->assertEquals(1, $json[0]['volume']);
        $this->assertEquals(1, $json[0]['percentage_change']);
    }
}
