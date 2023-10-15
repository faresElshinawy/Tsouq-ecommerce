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
            'transaction_id'=>'22736746NF804280K',
            'refundable_id'=>fake()->numberBetween(1,5),
            'refundable_type'=>'App\Models\Order',
            'total_amount'=>fake()->numberBetween(100,1000),
            'refund_reason'=>fake()->randomElement([
                'broken items',
                'items is used',
                'wrong order',
                'wrong address',
            ])
        ];
    }
}
