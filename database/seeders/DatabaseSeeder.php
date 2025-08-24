<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\TicketSeeder;
use Database\Seeders\MessageSeeder;
use Database\Seeders\AttachmentSeeder;
use Database\Seeders\DepartmentSeeder;


/**
 * Primary database seeder.
 *
 * Orchestrates domain seeders to populate core tables for development/testing.
 * Adjust volumes and data shapes in the individual seeder/factory classes.
 */
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * Calls child seeders in sequence. Ensure seeder/factory logic accounts for
     * foreign key dependencies (e.g., users/departments before tickets/messages).
     *
     * @return void
     */
    public function run(): void
    {

        $this->call([
            DepartmentSeeder::class,
            UserSeeder::class,
            MessageSeeder::class,
            AttachmentSeeder::class,
            TicketSeeder::class,
        ]);

        // \App\Models\User::factory(10)->create();
        // \App\Models\Ticket::factory(50)->create();
        // \App\Models\Message::factory(50)->create();
        // \App\Models\Attachment::factory(50)->create();

    }
}
