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
        $currentYear = now()->year;
    
        $years = [$currentYear, $currentYear - 1, $currentYear - 2, $currentYear - 3];
    
        $loansPerYear = RiskReport::selectRaw('EXTRACT(YEAR FROM date_rated) as year, SUM(applied_loan) as total_loan')
            ->whereRaw('EXTRACT(YEAR FROM date_rated) >= ?', [$currentYear - 3]) // Fetch 4 years
            ->groupBy('year')
            ->pluck('total_loan', 'year')
            ->toArray();
    
        $stats = [];
    
        foreach ($years as $index => $year) {
            // Stop after displaying the latest 3 years
            if ($index >= 3) break; 
    
            $currentLoan = $loansPerYear[$year] ?? 0;
            $previousLoan = $years[$index + 1] ?? null;
    
            $arrowIcon = null;
            $changePercentage = null;
    
            if (!is_null($previousLoan) && isset($loansPerYear[$previousLoan])) {
                $change = (($currentLoan - $loansPerYear[$previousLoan]) / $loansPerYear[$previousLoan]) * 100;
                $changePercentage = number_format(abs($change), 2) . '%';
                $arrowIcon = $change > 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down';
            }
    
            $stats[] = Stat::make(
                "Total Applied Loan $year",
                '₱' . number_format($currentLoan, 2)
            )
            ->description($previousLoan !== null ? ($change > 0 ? "+$changePercentage" : "-$changePercentage") : "0%")
            ->descriptionIcon($arrowIcon ?? 'heroicon-m-minus-circle')
            ->color($change > 0 ? 'success' : ($change < 0 ? 'danger' : 'gray'));
        }
    
        return $stats;
    }
    

}
