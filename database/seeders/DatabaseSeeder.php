<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Feedback;
use App\Models\OrderItem;
use App\Models\ProductSize;
use CreateAdminUserSeeder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@test.com',
        //     'password'=>Hash::make(12345678),
        //     'role'=>'admin'
        // ]);

        $this->call([
            UserSeeder::class,
            PermissionSeeder::class,
            FirstAdminSeeder::class,
            SettingSeeder::class,
            CountrySeeder::class,
            CategorySeeder::class,
            BrandSeeder::class,
            SizeSeeder::class,
            ColorSeeder::class,
            ProductSeeder::class,
            ProductSizeSeeder::class,
            ProductColorSeeder::class,
            ProductImageSeeder::class,
            RateSeeder::class,
            AddressSeeder::class,
            FeedbackSeeder::class,
            VoucherSeeder::class,
            WishListSeeder::class,
            WishListItemSeeder::class,
            OrderSeeder::class,
            OrderItemSeeder::class,
            SubscriberSeeder::class,
            ChatSeeder::class,
            ChatMessageSeeder::class,
            RefundSeeder::class,
            // CreditCardSeeder::class,//dont seed credit card table because i disabled it from the website so it will not show up
            // CitySeeder::class,//dont seed city table because i disabled it from the website so it will not show up
        ]);
    }
}
