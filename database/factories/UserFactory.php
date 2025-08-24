<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use App\Models\Department;

/**
 * User factory.
 *
 * Generates realistic user records for testing/seeding:
 * - Random name and unique safe email
 * - Optional email verification timestamp
 * - Hashed default password (memoized for performance)
 * - Role in {user, agent, admin}
 * - Department chosen from existing records or created via factory
 *
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Memoized hashed password used by the factory.
     *
     * @var string|null
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * Timestamps are kept consistent and within the last year.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Random date between 1 year ago and now (used for created_at/updated_at)
        $random_date = fake()->dateTimeBetween('-1 year', 'now');

        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => fake()->optional()->dateTimeBetween('-1 year', 'now'),
            'password' => static::$password ??= Hash::make('password'),
            'role' => fake()->randomElement(['user', 'agent', 'admin']),
            'department_id' => Department::inRandomOrder()->first()?->id ?? Department::factory(),
            'created_at' => $random_date,
            'updated_at' => $random_date,
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return static
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
