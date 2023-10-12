<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Address>
 */
class AddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id'=>fake()->numberBetween(1,100),
            'country_id'=>fake()->numberBetween(1,20),
            // 'city_id'=>fake()->numberBetween(1,20),
            'city_spare'=> fake()->city(),
            'phone'=>'01100162900',
            'street'=>fake()->streetAddress(),
            'building_number'=>fake()->numberBetween(1,50)
        ];
    }
}
