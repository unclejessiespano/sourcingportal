<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Line>
 */
class LineFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'qty'=>fake()->numberBetween(1,2000),
            'net_price'=>fake()->randomFloat(2, 0, 1000),
            'currency'=>fake()->currencyCode,
            'order_unit'=>'each',
            'order_price_unit'=>'each'
        ];
    }
}
