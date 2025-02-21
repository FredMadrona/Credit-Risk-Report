<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\RiskReport;
use App\Models\Client;
use App\Models\Branch;

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
            'type' => $this->faker->randomElement(['Personal Loan', 'Business Loan']),
            'pn_number' => strtoupper($this->faker->bothify('PN-###-####')),
            'segment' => $this->faker->randomElement(['Retail', 'Corporate']),
            'frp_class' => $this->faker->randomElement(['A', 'B', 'C']),
            'applied_loan' => $this->faker->randomFloat(2, 1000, 500000), // Loan amount
            'date_rated' => $this->faker->date(),
            'score' => $this->faker->numberBetween(300, 850),
            'risk' => $this->faker->randomElement(['Low', 'Medium', 'High']),
            'risk_desc' => $this->faker->sentence(),
            'next_review_date' => $this->faker->date(),
            'remarks' => $this->faker->optional()->sentence(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
