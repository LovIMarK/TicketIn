<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Department;

/**
 * Seeds the departments table with a predefined catalog.
 *
 * Idempotent: uses updateOrCreate keyed by the 'slug' to avoid duplicates
 * when the seeder is executed multiple times.
 */
class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $departments = [
            'Information Technology'     => 'it',
            'Human Resources'            => 'hr',
            'Marketing'                  => 'mktg',
            'Sales'                      => 'sales',
            'Finance'                    => 'fin',
            'Customer Support'           => 'support',
            'Research and Development'   => 'rnd',
            'Operations'                 => 'ops',
            'Procurement and Logistics'  => 'proc',
        ];

        foreach ($departments as $name => $slug) {
            Department::updateOrCreate(
                ['slug' => $slug],
                ['name' => $name]
            );
        }
    }
}
