<?php

namespace App\Filament\Exports;

use App\Models\RiskReport;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class RiskReportExporter extends Exporter
{
    protected static ?string $model = RiskReport::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('risk_number'),
            ExportColumn::make('client.name'),
            ExportColumn::make('type'),
            ExportColumn::make('pn_number'),
            ExportColumn::make('branch.name'),
            ExportColumn::make('segment'),
            ExportColumn::make('frp_class'),
            ExportColumn::make('applied_loan'),
            ExportColumn::make('date_rated'),
            ExportColumn::make('score'),
            ExportColumn::make('risk'),
            ExportColumn::make('risk_desc'),
            ExportColumn::make('next_review_date'),
            ExportColumn::make('remarks'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your risk report export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
