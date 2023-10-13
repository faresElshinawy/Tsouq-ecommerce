<?php

namespace Database\Seeders;

use App\Models\Refund;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RefundSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Refund::factory()->count(20)->create();
    }
}
