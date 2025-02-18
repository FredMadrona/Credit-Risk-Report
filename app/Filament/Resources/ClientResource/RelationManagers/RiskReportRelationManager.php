<?php

namespace App\Filament\Resources\ClientResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RiskReportRelationManager extends RelationManager
{
    protected static string $relationship = 'RiskReport';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('type')
                    ->required()
                    ->options([
                        'ICRR' => 'ICRR',
                        'BRR' => 'BRR',
                    ]),    
                Forms\Components\TextInput::make('pn_number')
                    ->label('PN Number')
                    ->required(),
                Forms\Components\Select::make('branch_id')
                    ->relationship(name:'branch', titleAttribute:'name')
                    ->searchable()
                    ->preload(),
                Forms\Components\TextInput::make('segment')
                    ->label('Segment')
                    ->required(),
                Forms\Components\TextInput::make('frp_class')
                    ->label('FRP Class')
                    ->required(),
                Forms\Components\TextInput::make('applied_loan')
                    ->label('Applied Loan')
                    ->numeric()
                    ->step(0.01)
                    ->required(),
                Forms\Components\DatePicker::make('date_rated')
                    ->required()
                    ->maxDate(now()),
                Forms\Components\TextInput::make('score')
                    ->label('Score')
                    ->numeric()
                    ->step(0.01)
                    ->required(),
                Forms\Components\Select::make('risk')
                    ->required()
                    ->options([
                        'N/A' => 'N/A',
                        'ICRR/BRR3' => 'ICRR/BRR3',
                        'ICRR/BRR4' => 'ICRR/BRR4',
                    ]),
                Forms\Components\Select::make('risk_desc')
                    ->required()
                    ->options([
                        'LOW RISK' => 'LOW RISK',
                        'MODERATE RISK' => 'MODERATE RISK',
                        'HIGH RISK' => 'HIGH RISK',
                        'N/A' => 'N/A',
                    ]),
                Forms\Components\DatePicker::make('next_review_date')
                    ->label('Next Review Date')
                    ->required(),
                Forms\Components\Textarea::make('remarks')
                    ->nullable(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('type')
            ->columns([
                Tables\Columns\TextColumn::make('type'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
