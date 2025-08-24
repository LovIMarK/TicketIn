<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Message;

/**
 * Attachment factory.
 *
 * Generates attachment records for testing/seeding purposes:
 * - Random JPEG filename
 * - Image URL as file path (adjust to a storage path if needed)
 * - Fixed MIME type (image/jpeg)
 * - Associates to an existing Message, or creates one if none exists
 *
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Attachment>
 */
class AttachmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * Creates realistic timestamps within the last year and links the attachment
     * to a message. When no messages exist, falls back to a Message factory.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Random date between 1 year ago and now (used for both created_at/updated_at)
        $random_date = fake()->dateTimeBetween('-1 year', 'now');
        return [
            'file_name' => fake()->word() . '.jpg',
            'file_path' => fake()->imageUrl(),
            'file_type' => 'image/jpeg',
            'message_id' => Message::inRandomOrder()->value('id') ?? Message::factory(),

            'created_at' => $random_date,
            'updated_at' => $random_date,
        ];
    }
}
