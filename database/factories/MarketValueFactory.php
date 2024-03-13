<?php

namespace Database\Factories;

use App\Models\Stock;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Stock>
 */
class MarketValueFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id' => fake()->unique()->randomNumber(),
            'stock_id' => Stock::factory(),
            'open' => fake()->randomNumber(4),
            'high' => fake()->randomNumber(4),
            'low' => fake()->randomNumber(4),
            'close' => fake()->randomNumber(4),
            'volume' => fake()->randomNumber(0),
            'interval_time' => fake()->date(),
        ];
    }
}
