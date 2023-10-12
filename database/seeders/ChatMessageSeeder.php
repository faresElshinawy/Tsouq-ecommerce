<?php

namespace Database\Seeders;

use App\Models\ChatMessage;
use App\Models\ChatMessages;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ChatMessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ChatMessage::factory()->count(20)->create();
    }
}
