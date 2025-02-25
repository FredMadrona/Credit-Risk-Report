<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

use App\Models\Employee;

class EmployeeSeeder extends Seeder
{
    public function run()
    {
        
        Employee::factory()->count(10)->create();

    }
}
