<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Refund>
 */
class RefundFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'refundable_id'=>fake()->numberBetween(1,10),
            'refundable_type'=>fake()->randomElement([
                'App\Models\Order',
                'App\models\orderItem'
            ]),
            'total_amount'=>fake()->numberBetween(100,10000),
            'refund_reason'=>fake()->randomElement([
                'broken',
                'item is used',
                'wrong color',
                'wrong item',
            ])
        ];
    }
}
