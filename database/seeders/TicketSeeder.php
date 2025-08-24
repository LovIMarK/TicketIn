<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ticket;

/**
 * Seeds the tickets table.
 *
 * Uses the Ticket factory to generate sample records for development/testing.
 */
class TicketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * Creates 50 tickets.
     *
     * @return void
     */
    public function run(): void
    {
        Ticket::factory(50)->create();
    }
}
