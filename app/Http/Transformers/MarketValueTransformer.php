<?php

namespace App\Http\Transformers;

use App\Models\MarketValue;

class MarketValueTransformer extends BaseTransformer
{
    /**
     * Transforms a MarketValue Eloquent Model into a json
     *
     * @param  MarketValue  $value
     * @return array<string, mixed>
     */
    public function transform(mixed $value): array
    {
        return [
            'open' => $value->open,
            'high' => $value->high,
            'low' => $value->low,
            'close' => $value->close,
            'volume' => $value->volume,
            'interval_time' => $value->interval_time->getTimestampMs(),
            'percentage_change' => $value->getPercentageChange(),
        ];
    }
}
