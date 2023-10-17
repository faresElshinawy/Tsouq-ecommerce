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
        return [
            'order_serial_code'=>fake()->sentence(1),
            'user_id'=>fake()->numberBetween(1,50),
            'address_id'=>fake()->numberBetween(1,20),
            'status'=>fake()->randomElement(['pending','in_progress','delivered','refunded']),
        ];
    }
}
