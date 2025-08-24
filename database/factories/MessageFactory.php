<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Ticket;


/**
 * Message factory.
 *
 * Generates message records for testing/seeding:
 * - Random paragraph as content
 * - Links to an existing Ticket/User when available, otherwise uses factories
 * - Timestamps within the last year (same value for created_at/updated_at)
 *
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Message>
 */
class MessageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Generate a random date between 1 year ago and now
        $random_date = fake()->dateTimeBetween('-1 year', 'now');

        return [
            'content' => fake()->paragraph(),
            'ticket_id' => Ticket::inRandomOrder()->value('id') ?? Ticket::factory(),
            'user_id' => User::inRandomOrder()->value('id') ?? User::factory(),
            'created_at' => $random_date,
            'updated_at' => $random_date,
        ];
    }
}
