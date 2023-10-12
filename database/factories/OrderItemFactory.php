<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderItem>
 */
class OrderItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'order_id'=>fake()->numberBetween(1,50),
            'product_id'=>fake()->numberBetween(1,80),
            'size_id'=>fake()->numberBetween(1,4),
            'color_id'=>fake()->numberBetween(1,10),
            'final_price'=>fake()->numberBetween(500,20000),
            'price'=>fake()->numberBetween(1000,20000),
            'discount'=>fake()->numberBetween(1,20),
        ];
    }
}
