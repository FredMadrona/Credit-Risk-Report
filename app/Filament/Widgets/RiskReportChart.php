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

        $years = range($currentYear - 4, $currentYear);

        $data = array_map(fn ($year) => RiskReport::whereYear('date_rated', $year)->count(), $years);

        return [
            'labels' => $years,
            'datasets' => [
                [
                    'label' => 'Number of Risk Reports',
                    'data' => $data,
                    'backgroundColor' => '#3490dc',
                    'borderColor' => '#3490dc',
                    'borderWidth' => 5,
                    'pointBackgroundColor' => '#A08963',
                    'pointBorderColor' => '#A08963',
                    'pointBorderWidth' => 10,
                    'pointHoverRadius' => 10,
                ],
            ],
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
