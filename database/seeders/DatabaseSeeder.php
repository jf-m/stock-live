<?php

namespace Database\Seeders;

use App\Models\Stock;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Stock::factory()->create([
            'id' => 1,
            'name' => 'Apple',
            'symbol' => 'AAPL',
        ]);
        Stock::factory()->create([
            'id' => 2,
            'name' => 'Microsoft',
            'symbol' => 'MSFT',
        ]);
        Stock::factory()->create([
            'id' => 3,
            'name' => 'Amazon',
            'symbol' => 'AMZN',
        ]);
        Stock::factory()->create([
            'id' => 4,
            'name' => 'Nvidia',
            'symbol' => 'NVDA',
        ]);
        Stock::factory()->create([
            'id' => 5,
            'name' => 'Meta',
            'symbol' => 'META',
        ]);
        Stock::factory()->create([
            'id' => 6,
            'name' => 'Tesla',
            'symbol' => 'TSLA',
        ]);
        Stock::factory()->create([
            'id' => 7,
            'name' => 'Walt Disney',
            'symbol' => 'DIS',
        ]);
        Stock::factory()->create([
            'id' => 8,
            'name' => 'IBM',
            'symbol' => 'IBM',
        ]);
        Stock::factory()->create([
            'id' => 9,
            'name' => 'Johnson & Johnson',
            'symbol' => 'JNJ',
        ]);
        Stock::factory()->create([
            'id' => 10,
            'name' => 'Boeing',
            'symbol' => 'BA',
        ]);
    }
}
