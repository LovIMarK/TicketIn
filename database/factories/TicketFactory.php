<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\user;
use App\Models\Message;
use App\Models\Ticket;



/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ticket>
 */
class TicketFactory extends Factory
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

        $priority = fake()->optional()->randomElement(['low', 'medium', 'high']);
        $status = $priority === null ? 'open' : fake()->randomElement(['open', 'in_progress', 'resolved', 'closed']);
        return [
            'title' => fake()->sentence(),
            'uuid' => fake()->uuid(),
            'priority' => $priority,
            'status' => $status,
            'user_id' => User::where('role', 'user')->inRandomOrder()->first()->id,
            'agent_id' => ($priority === null || $status === 'open')
                ? null
                : User::where('role', 'agent')->inRandomOrder()->first()?->id,
            'created_at' => $random_date,
            'updated_at' => $random_date,
            'closed_at' => $status === 'closed' ? fake()->dateTimeBetween($random_date, 'now') : null,
        ];
    }
    public function configure()
    {
        return $this->afterCreating(function (Ticket $ticket) {
            Message::factory()->create([
                'ticket_id' => $ticket->id,
            ]);
        });
    }
}
