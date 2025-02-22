<?php

namespace App\Filament\Widgets;
use App\Models\RiskReport;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class RiskReportOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Applied Loan 2023', '₱' . number_format(RiskReport::whereYear('created_at', 2023)->sum('applied_loan'), 2)),
            Stat::make('Total Applied Loan 2024', '₱' . number_format(RiskReport::whereYear('created_at', 2024)->sum('applied_loan'), 2)),
            Stat::make('Total Applied Loan 2025', '₱' . number_format(RiskReport::whereYear('created_at', 2025)->sum('applied_loan'), 2)),
        ];
    }
}
