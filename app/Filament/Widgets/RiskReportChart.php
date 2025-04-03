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
            'day' => 'Day',
            'week' => 'Week',
            'month' => 'Month',
            'year' => 'Year',
        ];
    }

    // Get chart data based on the selected filter
    protected function getData(): array
    {
        $activeFilter = $this->filter;
        $query = RiskReport::query();

        switch ($activeFilter) {
      

                case 'day':
                    $labels = [];
                    $data = [];
                
                    for ($i = 6; $i >= 0; $i--) { // Loop through last 7 days
                        $date = Carbon::now()->subDays($i);
                        $labels[] = $date->format('l'); // Gets the full day name (e.g., "Monday")
                        $data[] = RiskReport::whereDate('date_rated', $date)->count();
                    }
                
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

                    case 'week':
                        $labels = [];
                        $data = [];
                    
                        for ($i = 3; $i >= 0; $i--) { // Loop through last 4 weeks
                            $startOfWeek = Carbon::now()->subWeeks($i)->startOfWeek();
                            $endOfWeek = Carbon::now()->subWeeks($i)->endOfWeek();
                            $labels[] = $startOfWeek->format('M d') . ' - ' . $endOfWeek->format('M d'); // Example: "Mar 04 - Mar 10"
                            $data[] = RiskReport::whereBetween('date_rated', [$startOfWeek, $endOfWeek])->count();
                        }
                    
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


                    case 'month':
                        $labels = [];
                        $data = [];
                    
                        for ($i = 5; $i >= 0; $i--) { // Loop through last 6 months
                            $date = Carbon::now()->subMonths($i);
                            $labels[] = $date->format('M Y'); // Example: "Jan 2024", "Feb 2024"
                            $data[] = RiskReport::whereYear('date_rated', $date->year)
                                                ->whereMonth('date_rated', $date->month)
                                                ->count();
                        }
                    
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
