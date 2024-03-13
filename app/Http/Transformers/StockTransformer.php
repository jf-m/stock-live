<?php

namespace App\Http\Transformers;

use App\Models\Stock;

class StockTransformer extends BaseTransformer
{
    /**
     * @param  Stock  $value
     * @return array<string, mixed>
     */
    public function transform(mixed $value): array
    {
        $marketValue = $value->getLatestMarketValue();

        return [
            'symbol' => $value->symbol,
            'name' => $value->name,
            'price' => $marketValue ? (new MarketValueTransformer())->transform($marketValue) : null,
        ];
    }
}
