<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\StockMarketController;

Route::get('/', function () {
    return view('welcome', [
        'stocks' => (new \App\Http\Transformers\StockTransformer())->transformCollection(\App\Models\Stock::all())
    ]);
});
