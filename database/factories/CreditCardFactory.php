<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CreditCard>
 */
class CreditCardFactory extends Factory
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
            'holder_name'=>fake()->name(),
            'card_number'=>fake()->creditCardNumber(),
            'cvv'=>fake()->numberBetween(100,900),
            'expire_month'=>fake()->numberBetween(1,12),
            'expire_year'=>fake()->numberBetween(23,27)
        ];
    }
}
