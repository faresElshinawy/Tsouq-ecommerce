<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Voucher>
 */
class VoucherFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'code'=>fake()->sentence(1),
            'price_limit'=>fake()->numberBetween(500,1000),
            'value'=>fake()->numberBetween(1,20),
            'status'=>fake()->randomElement(['active','inactive']),
            'type'=>fake()->randomElement(['percentage','row_discount'])
        ];
    }
}
