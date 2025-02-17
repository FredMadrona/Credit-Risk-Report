<?php

namespace App\Filament\Resources\RiskReportResource\Pages;

use App\Filament\Resources\RiskReportResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRiskReport extends EditRecord
{
    protected static string $resource = RiskReportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
