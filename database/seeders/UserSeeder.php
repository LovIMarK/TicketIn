<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->count(10)->create(['role' => 'user']);
        User::factory()->count(5)->create(['role' => 'agent']);
        User::factory()->count(2)->create(['role' => 'admin','department_id' => 1]);
    }
}
