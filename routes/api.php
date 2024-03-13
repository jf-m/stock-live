<?php

use App\Http\Controllers\Api\StockPriceApiController;
use Illuminate\Support\Facades\Route;

Route::prefix('stock/{stock}')->group(function () {
    Route::prefix('price')->group(function () {
        Route::get('latest', [StockPriceApiController::class, 'getLatestPrice']);
    });
});
