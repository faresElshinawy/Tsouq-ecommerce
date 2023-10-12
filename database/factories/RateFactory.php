<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Rate>
 */
class RateFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id'=>fake()->numberBetween(1,20),
            'product_id'=>fake()->numberBetween(1,80),
            'comment'=>'the product is very good and useful',
            'rate'=>fake()->numberBetween(1,5)
        ];
    }
}
