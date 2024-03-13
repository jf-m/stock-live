<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Transformers\MarketValueTransformer;
use App\Models\Stock;
use Illuminate\Http\JsonResponse;

class StockPriceApiController extends Controller
{
    public function getLatestPrice(Stock $stock): JsonResponse
    {
        $price = $stock->getLatestMarketValue();
        if (! $price) {
            abort(404);
        }

        return response()->json((new MarketValueTransformer())->transform($price));
    }
}
