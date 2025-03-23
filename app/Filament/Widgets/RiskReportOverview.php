<?php

namespace App\Filament\Widgets;

use App\Models\RiskReport;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class RiskReportOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        // Get the current year dynamically
        $currentYear = now()->year;

        // Get the last 3 years dynamically and reverse the order
        $years = [$currentYear, $currentYear - 1, $currentYear - 2];

        $stats = [];

        foreach ($years as $index => $year) {
            $currentLoan = RiskReport::whereYear('date_rated', $year)->sum('applied_loan');
            $previousLoan = $index < count($years) - 1 
                ? RiskReport::whereYear('date_rated', $years[$index + 1])->sum('applied_loan') 
                : null;

            $arrowIcon = null;
            $changePercentage = null;
            if (!is_null($previousLoan) && $previousLoan > 0) {
                $change = (($currentLoan - $previousLoan) / $previousLoan) * 100;
                $changePercentage = number_format(abs($change), 2) . '%';
                $arrowIcon = $change > 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down';
            }

       
            $stats[] = Stat::make(
                "Total Applied Loan $year",
                '₱' . number_format($currentLoan, 2)
            )
            ->description($previousLoan !== null ? ($change > 0 ? "+$changePercentage" : "-$changePercentage") : 'No Data')
            ->descriptionIcon($arrowIcon)
            ->color($change > 0 ? 'success' : ($change < 0 ? 'danger' : 'gray')); 
        }

        return $stats;
    }
}
