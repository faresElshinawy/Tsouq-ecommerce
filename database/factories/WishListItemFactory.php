<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\WishListItem>
 */
class WishListItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'wish_list_id'=>fake()->numberBetween(1,50),
            'product_id'=>fake()->numberBetween(1,50)
        ];
    }
}
