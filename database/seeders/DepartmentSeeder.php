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
            ['name' => 'Compliance Department'],
            ['name' => 'Internal Audit Department'],
            ['name' => 'Finance Department'],
            ['name' => 'General Services Department'],
            ['name' => 'Information Technology Department'],

        ];

        Department::insert($departments);
    }
}
