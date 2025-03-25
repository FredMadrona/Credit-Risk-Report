<?php

namespace App\Filament\Widgets;

use App\Models\RiskReport;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

class RiskReportChart extends ChartWidget
{
    protected static ?int $sort = 3;

    protected static ?string $heading = 'Risk Reports Rated';

    // Default filter (set to 'year' to show the yearly view first)
    public ?string $filter = 'year';

    // Define available filter options
    protected function getFilters(): ?array
    {
        return [
            'today' => 'Today',
            'week' => 'Last Week',
            'month' => 'Last Month',
            'year' => 'This Year',
        ];
    }

    // Get chart data based on the selected filter
    protected function getData(): array
    {
        $activeFilter = $this->filter;
        $query = RiskReport::query();

        switch ($activeFilter) {
            case 'today':
                $query->whereDate('date_rated', Carbon::today());
                $labels = ['Today'];
                break;

            case 'week':
                $query->whereBetween('date_rated', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
                $labels = ['This Week'];
                break;

            case 'month':
                $query->whereMonth('date_rated', Carbon::now()->month)
                      ->whereYear('date_rated', Carbon::now()->year);
                $labels = ['This Month'];
                break;

            case 'year':
            default:
                $currentYear = now()->year;
                $years = range($currentYear - 4, $currentYear);
                $labels = $years;
                $data = array_map(fn ($year) => RiskReport::whereYear('date_rated', $year)->count(), $years);
                return [
                    'labels' => $labels,
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

        // Get filtered data count
        $data = [$query->count()];

        return [
            'labels' => $labels,
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
