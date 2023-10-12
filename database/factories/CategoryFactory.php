<?php

namespace Database\Factories;

use App\Traits\FetchImage;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    use FetchImage;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $randomImage = [
            '643dde6cd6c2c9.40566832.jpg',
            '643ddf34c9ef47.02133873.jpg',
            '643de01c6e2a83.36053598.jpg',
            '643de8957dff11.70913470.jpg',
            'pexels-abhilash-sahoo-4405863.jpg',
            'pexels-jess-bailey-designs-788946.jpg',
            'pexels-miljan-rašević-13302159.jpg',
            'pexels-mnz-1599005.jpg',
            'pexels-oğuzhan-öncü-14168781.jpg',
            'pexels-shane-aldendorff-786003.jpg'
        ];
        $query = fake()->randomElement([
            'perfums',
            'makeup',
            'winter mens wear',
            'summer mens wear',
            'rtx 3070',
            'shoes',
            'watches',
            'books',
            'toys'
        ]);
        return [
            'name'=>fake()->name(),
            // 'image'=>fake()->imageUrl(480,680),
            'image'=>$this->getRandomImageUrlFromGoogle($query) ?? fake()->randomElement($randomImage)
        ];
    }
}
