<?php

namespace App\Filament\Resources;
use App\Models\RiskReport;
use App\Filament\Resources\RiskReportResource\Pages;
use App\Filament\Resources\RiskReportResource\RelationManagers;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RiskReportResource extends Resource
{
    protected static ?string $model = RiskReport::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('risk_number')
                 ->label('Risk Number')
                 ->disabled()
                 ->required(),
                 Forms\Components\Select::make('client_id')
                    ->relationship('client', titleAttribute:'full_name')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->createOptionForm([
                        Forms\Components\TextInput::make('full_name')
                            ->label('Client name')
                            ->required()
                            ->maxlength(255)
                    ]),
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
                    ->relationship('branch', 'name')
                    ->searchable()
                    ->preload()
                    ->createOptionForm([
                        Forms\Components\TextInput::make('name')
                            ->label('Name')
                            ->required()
                            ->maxlength(255) 
                    ]),
                Forms\Components\TextInput::make('segment')
                    ->label('Segment')
                    ->required(),
                Forms\Components\TextInput::make('frp_class')
                    ->label('FRP Class')
                    ->required(),
                Forms\Components\TextInput::make('applied_load')
                    ->label('Applied Loan')
                    ->numeric()
                    ->step(0.01)
                    ->required(),
                Forms\Components\DatePicker::make('date_rated')
                    ->required()
                    ->maxDate(now()),
                Forms\Components\TextInput::make('Score')
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
                Forms\Components\DatePicker::make('date_rated')
                    ->label('Next Review Date')
                    ->required(),
                Forms\Components\Textarea::make('remarks')
                    ->nullable(),
                ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('risk_number')
                    ->searchable(), 
                Tables\Columns\TextColumn::make('client.first_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('type'),
                Tables\Columns\TextColumn::make('pn_number'),
                Tables\Columns\TextColumn::make('branch.name'),
                Tables\Columns\TextColumn::make('segment'),
                Tables\Columns\TextColumn::make('frp_class'),
                Tables\Columns\TextColumn::make('applied_loan'),
            ])
            ->filters([
             //
             ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRiskReports::route('/'),
            'create' => Pages\CreateRiskReport::route('/create'),
            'edit' => Pages\EditRiskReport::route('/{record}/edit'),
        ];
    }
}
