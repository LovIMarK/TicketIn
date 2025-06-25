<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\user;
use App\Models\Ticket;


/**
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
            'created_at' => $random_date,
            'updated_at' => $random_date,
        ];
    }
}
