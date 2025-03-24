<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\RiskReport;

class RiskReportSeeder extends Seeder
{
    public function run()
    {
        RiskReport::factory()->count(100)->create();
    }
}
