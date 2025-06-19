<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\user;



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

        return [
            'title' => fake()->sentence(),
            'description' => fake()->paragraph(),
            'status' => fake()->randomElement(['open', 'in_progress','resolved', 'closed']),
            'priority' => fake()->randomElement(['low', 'medium', 'high']),
            'user_id' => User::factory(),
            'created_at' => $random_date,
            'updated_at' => $random_date,

        ];
    }
}
