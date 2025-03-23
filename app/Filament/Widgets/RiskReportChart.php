<?php

namespace App\Filament\Widgets;

use App\Models\RiskReport;
use Filament\Widgets\ChartWidget;

class RiskReportChart extends ChartWidget
{
    protected static ?int $sort = 3;

    protected static ?string $heading = 'Risk Reports Rated Per Year';

    protected function getData(): array
    {
        
        $currentYear = now()->year;
        
        $years = [$currentYear - 2, $currentYear - 1, $currentYear];

      
        $data = array_map(fn ($year) => RiskReport::whereYear('date_rated', $year)->count(), $years);

        return [
            'labels' => $years,
            'datasets' => [
                [
                    'label' => 'Number of Risk Reports',
                    'data' => $data,
                    'backgroundColor' => ['#4F46E5', '#16A34A', '#DC2626'],
                ],
            ],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
