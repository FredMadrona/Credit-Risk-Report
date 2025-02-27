<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\RiskReport;
use App\Models\Client;
use App\Models\Branch;
use App\Models\Employee;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RiskReport>
 */
class RiskReportFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = RiskReport::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'client_id' => Client::factory(), // Generates a new client or use existing
            'branch_id' => Branch::inRandomOrder()->first()->id ?? Branch::factory(),
            'type' => $this->faker->randomElement(['ICRR', 'BRR']),
            'pn_number' => strtoupper($this->faker->bothify('PN-###-####')),
            'segment' => $this->faker->randomElement(['Retail', 'Corporate']),
            'frp_class' => $this->faker->randomElement(['A', 'B', 'C']),
            'applied_loan' => $this->faker->randomFloat(2, 1000, 500000), // Loan amount
            'date_rated' => $this->faker->dateTimeBetween('2020-01-01', '2025-12-31')->format('Y-m-d'),
            'score' => $this->faker->numberBetween(300, 850),
            'risk' => $this->faker->randomElement(['ICRR/BRR3', 'ICRR/BRR4', 'ICRR/BRR5']),
            'risk_desc' => $this->faker->randomElement(['LOW RISK', 'MODERATE RISK', 'HIGH RISK']),
            'next_review_date' => $this->faker->date(),
            'requested_by' => Employee::inRandomOrder()->first()->id ?? Employee::factory(),
            'assessed_by' => Employee::inRandomOrder()->first()->id ?? Employee::factory(),
            'remarks' => $this->faker->optional()->sentence(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
