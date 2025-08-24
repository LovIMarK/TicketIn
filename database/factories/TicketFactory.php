<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\user;
use App\Models\Message;
use App\Models\Ticket;



/**
 * Ticket factory.
 *
 * Generates ticket records for testing/seeding with:
 * - Optional priority (low|medium|high|null)
 * - Status derived from priority (open|in_progress|resolved|closed)
 * - Creator chosen from users with role 'user'
 * - Optional agent assignment when not open/unprioritized
 * - Consistent timestamps within the last year
 *
 * Also creates an initial Message after the Ticket is persisted (see configure()).
 *
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ticket>
 */
class TicketFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * Notes:
     * - Assumes at least one 'user' exists; otherwise adjust to use User::factory().
     * - 'closed_at' is set only when status is 'closed'.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Random date between 1 year ago and now (used for both created_at/updated_at)
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

    /**
     * After creating a ticket, generate an initial message tied to it.
     *
     * @return static
     */
    public function configure()
    {
        return $this->afterCreating(function (Ticket $ticket) {
            Message::factory()->create([
                'ticket_id' => $ticket->id,
            ]);
        });
    }
}
