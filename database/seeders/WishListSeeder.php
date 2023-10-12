<?php

namespace Database\Seeders;

use App\Models\WishList;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class WishListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        WishList::factory()->count(100)->create();
    }
}
