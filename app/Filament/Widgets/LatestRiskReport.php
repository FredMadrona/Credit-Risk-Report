<?php

namespace App\Filament\Widgets;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Filament\Tables\Columns\TextColumn;
use App\Models\RiskReport;

class LatestRiskReport extends BaseWidget
{
    protected int $recordsPerPage = 5; 
    protected static ?int $sort = 2;


    public function table(Table $table): Table
    {
        return $table
            ->query(
                RiskReport::query()
                    ->latest('date_rated') 
                    ->limit(5) 
            )
            ->columns([
                TextColumn::make('risk_number')->label('Risk Number'),
                TextColumn::make('date_rated')
                    ->label('Date & Time Rated')
                    ->dateTime('M d, Y H:i'),
               
            ]);
    }
}
