<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\RiskReport;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;

class RiskReportChartTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_filters_risk_reports_by_date()
    {
        // Create test data
        RiskReport::factory()->create(['date_rated' => Carbon::today()]);
        RiskReport::factory()->create(['date_rated' => Carbon::now()->subWeek()]);
        RiskReport::factory()->create(['date_rated' => Carbon::now()->subMonth()]);

        // Check "Today" filter
        $this->assertEquals(1, RiskReport::whereDate('date_rated', Carbon::today())->count());

        // Check "Last Week" filter
        $this->assertEquals(1, RiskReport::whereBetween('date_rated', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count());

        // Check "Last Month" filter
        $this->assertEquals(1, RiskReport::whereMonth('date_rated', Carbon::now()->month)->count());
    }
}
