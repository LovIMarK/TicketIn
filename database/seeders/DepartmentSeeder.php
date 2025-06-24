<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Department;

class DepartmentSeeder extends Seeder
{
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
