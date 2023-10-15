<?php

namespace Database\Factories;

use App\Traits\FetchImage;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
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
            '643cc0f7444c49.35095125.jpg',
            '643e7961930e43.23654466.jpg',
            '643e79d1251341.06756422.jpg',
            '643e7a31175086.46257612.jpg',
            '643de370e2b662.67452472.jpg',
            '643de0a0cee1f0.89140087.jpg',
            '643ddfa747fa64.79484647.jpg',
            '643ddee93e0ad3.80537891.jpg',
            '643de06352b490.84974403.jpg',
            '643de5960b2180.54903129.jpg',
            '643de503213c83.75622001.jpg',
            '643de5960b2180.54903129.jpg',
            '643de747331934.67931382.jpg',
            '643cc263260731.32100920.jpg',
            '643ddee93e0ad3.80537891.jpg',
        ];
        $query = fake()->randomElement([
            'iphone',
            'zara mens wear',
            'h&m mens wear',
            'mens sports wear',
            'zara',
            'samsung s21',
            'samsung s20',
            'rtx 3060',
            'msi optix g24 series curved',
            'canon',
            'nikon',
            'rtx',
            'pc',
            'shoes',
            'nike',
            'adidas',
            'macbook',
            'ryzen 3600',
            'rtx 3080',
        ]);
        return [
            'name'=>fake()->name(),
            'description'=>fake()->sentence(),
            // 'image'=>fake()->imageUrl(),
            'image'=>$this->getRandomImageUrlFromGoogle($query) ?? fake()->randomElement($randomImage),
            'price'=>fake()->numberBetween(10,10000),
            'count'=> 50,
            'discount'=> 15,
            'status'=>fake()->randomElement(['active','pending']),
            'category_id'=>fake()->numberBetween(1,10),
            'brand_id'=>fake()->numberBetween(1,10),
            'user_id'=> fake()->numberBetween(1,50),
            'solded_out'=>fake()->numberBetween(1,50),
            'refunds'=>fake()->numberBetween(1,20),
            'total_gain'=>fake()->numberBetween(50,1000),
        ];
    }
}
