<?php

namespace Database\Seeders;

use App\Models\WishListItem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WishListItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        WishListItem::factory()->Count(100)->create();
    }
}
