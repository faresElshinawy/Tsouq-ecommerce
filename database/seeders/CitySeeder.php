<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Seeder;
use Database\Factories\CityFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        City::factory()->count(100)->create();
    }
}
