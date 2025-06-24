<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\TicketSeeder;
use Database\Seeders\MessageSeeder;
use Database\Seeders\AttachementSeeder;
use Database\Seeders\DepartmentSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call([
            DepartmentSeeder::class,
            UserSeeder::class,
            TicketSeeder::class,
            MessageSeeder::class,
            AttachementSeeder::class,
        ]);

        // \App\Models\User::factory(10)->create();
        // \App\Models\Ticket::factory(50)->create();
        // \App\Models\Message::factory(50)->create();
        // \App\Models\Attachement::factory(50)->create();

    }
}
