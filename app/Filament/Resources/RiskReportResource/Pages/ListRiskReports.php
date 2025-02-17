<?php

namespace App\Filament\Resources\RiskReportResource\Pages;

use App\Filament\Resources\RiskReportResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRiskReports extends ListRecords
{
    protected static string $resource = RiskReportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
