<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Employee;

class EmployeeSeeder extends Seeder
{
    public function run()
    {
        $employees = [
            [
                'name' => 'John Doe',
                'branch_id' => 1,  // ✅ Correct column
                'department_id' => 3,  // ✅ Correct column
                'employee_type_id' => 'Part-time',  // ✅ Correct column
                'job_position_id' => 'Human Resource',  // ✅ Correct column
                'birthday' => '1990-05-15',
                'hire_date' => '2020-06-01',
             ],
            [
                'name' => 'Jane Smith',
                'branch_id' => 2,  // ✅ Correct column
                'department_id' => 1,  // ✅ Correct column
                'employee_type_id' => 'Full-time',  // ✅ Correct column
                'job_position_id' => 'Software Engineer',
                'birthday' => '1985-11-20',
                'hire_date' => '2018-03-12',
            ],
        ];

        Employee::insert($employees);
    }
}
