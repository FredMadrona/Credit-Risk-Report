<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Employee;
use App\Models\Branch;
use App\Models\Department;
use Carbon\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{

    protected $model = Employee::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $hireDate = Carbon::parse($this->faker->date());

        return [
            'name' => $this->faker->name(),
            'branch_id' => Branch::inRandomOrder()->first()->id ?? Branch::factory(),
            'department_id' => Department::inRandomOrder()->first()->id ?? Department::factory(),
            'employee_type' => $this->faker->randomElement(['Regular', 'Probationary', 'Contractual']),
            'job_position' => $this->faker->randomElement(['Associate',
            'Department Head',
            'CEO',
            'COO',
            'Vice President',
            'Deputy Head',
            'Area Head',
            'Unit Head',]),
            'birth_date' => $this->faker->date(),
            'hire_date' => $hireDate->format('Y-m-d'),
            'date_regularized' => Carbon::parse($hireDate)->addMonths(6)->format('Y-m-d'),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
