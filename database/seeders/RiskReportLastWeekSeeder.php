<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RiskReport;
use Carbon\Carbon;

class RiskReportForGraphSeeder extends Seeder
{
    public function run()
    {
        // Generate daily reports for the last 30 days
        for ($i = 0; $i < 30; $i++) {
            RiskReport::factory()->create(['date_rated' => Carbon::now()->subDays($i)]);
        }

        // Generate weekly reports for the last 12 weeks
        for ($i = 0; $i < 12; $i++) {
            RiskReport::factory()->create(['date_rated' => Carbon::now()->subWeeks($i)]);
        }

        // Generate monthly reports for the last 12 months
        for ($i = 0; $i < 12; $i++) {
            RiskReport::factory()->create(['date_rated' => Carbon::now()->subMonths($i)]);
        }

        // Generate yearly reports for the last 5 years
        for ($i = 0; $i < 5; $i++) {
            RiskReport::factory()->create(['date_rated' => Carbon::now()->subYears($i)]);
        }
    }
}
