<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Department;

class DepartmentSeeder extends Seeder
{
    public function run()
    {
        $departments = [
            ['department_name' => 'Finance'],
            ['department_name' => 'Human Resources'],
            ['department_name' => 'IT'],
            ['department_name' => 'Marketing'],
        ];

        Department::insert($departments);
    }
}
