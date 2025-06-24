<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Message;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Attachement>
 */
class AttachementFactory extends Factory
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
            'file_name' => fake()->word() . '.jpg',
            'file_path' => fake()->imageUrl(),
            'file_type' => 'image/jpeg',
            'message_id' => Message::factory(),

            'created_at' => $random_date,
            'updated_at' => $random_date,
        ];
    }
}
