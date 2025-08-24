<?php

namespace Database\Seeders;

use App\Models\Message;
use Illuminate\Database\Seeder;

/**
 * Seeds the messages table.
 *
 * Uses the Message factory to generate sample records for development/testing.
 */
class MessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * Creates 5 messages.
     *
     * @return void
     */
    public function run(): void
    {
        Message::factory(5)->create();
    }
}
