<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Branch;
use App\Models\Employee;

class BranchManagerFactory extends Factory
{
    public function definition(): array
    {
        return [
            'branch_manager_id' => Employee::inRandomOrder()->first()->id, 
            'branch_id' => Branch::inRandomOrder()->first()->id, 
        ];
    }
}
