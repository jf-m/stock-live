<?php

namespace Tests\Feature\Transformers;

use App\Http\Transformers\StockTransformer;
use App\Models\Stock;
use Tests\TestCase;

class StockTransformerTest extends TestCase
{
    public function test_stock_transform_works(): void
    {
        $stock = Stock::factory()->make([
            'name' => 'Microsoft',
            'symbol' => 'MSFT',
        ]);

        $json = (new StockTransformer())->transform($stock);
        $this->assertEquals('Microsoft', $json['name']);
        $this->assertEquals('MSFT', $json['symbol']);
    }
}
