<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;


/**
 * Seeds the users table with a role distribution.
 *
 * Generates:
 * - 10 regular users
 * - 5 agents
 * - 2 admins (explicitly assigned to department_id = 1)
 *
 * Uses model factories to create realistic records.
 */
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        User::factory()->count(10)->create(['role' => 'user']);
        User::factory()->count(5)->create(['role' => 'agent']);
        User::factory()->count(2)->create(['role' => 'admin','department_id' => 1]);
    }
}
