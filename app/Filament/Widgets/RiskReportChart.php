<?php

namespace App\Filament\Widgets;

use App\Models\RiskReport;
use Filament\Widgets\ChartWidget;

class RiskReportChart extends ChartWidget
{
    protected static ?string $heading = 'Risk Reports Per Year';

    protected function getData(): array
    {
        $years = [2023, 2024, 2025];

        $data = [];
        foreach ($years as $year) {
            $data[] = RiskReport::whereYear('date_rated', $year)->count();
        }

        return [
            'labels' => $years,
            'datasets' => [
                [
                    'label' => 'Number of Risk Reports',
                    'data' => $data,
                    'backgroundColor' => ['#4F46E5', '#16A34A', '#DC2626'], // Different colors for each year
                ],
            ],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
