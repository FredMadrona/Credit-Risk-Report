<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Branch;
use App\Models\Employee;

class BranchFactory extends Factory
{
    protected $model = Branch::class;

    public function definition(): array
    {
        return [
            'branch_name' => $this->faker->company,
            'branch_code' => $this->faker->unique()->bothify('BR###'),
            'branch_address' => $this->faker->address,
            'branch_phone' => $this->faker->phoneNumber,
            'branch_email' => $this->faker->unique()->safeEmail,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
