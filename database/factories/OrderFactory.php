<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $years = ['2023', '2024'];
        $random = array_rand($years);
        $current = \Carbon\Carbon::now();
        $document_date = $current->addDays(160)->subDays(rand(0,365))->format('Y-m-d');
        return [
            'PO'=>fake()->numberBetween(33000000, 33999999),
            'document_date'=>$document_date
        ];
    }
}
