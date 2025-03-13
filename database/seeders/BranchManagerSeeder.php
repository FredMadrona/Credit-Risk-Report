<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Branch;
use App\Models\Employee;

class BranchManagerSeeder extends Seeder
{
    public function run(): void
    {
        $employees = Employee::pluck('id')->toArray();
        
        if (empty($employees)) {
            return; 
        }

        Branch::all()->each(function ($branch) use ($employees) {
            $branch->update([
                'branch_manager_id' => fake()->randomElement($employees),
            ]);
        });
    }
}
