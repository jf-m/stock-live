<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome', [
        'stocks' => (new \App\Http\Transformers\StockTransformer())->transformCollection(\App\Models\Stock::all()),
    ]);
});
