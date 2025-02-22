<?php

namespace App\Filament\Resources;

use App\Models\RiskReport;
use Filament\Forms\Components\Select;
use App\Filament\Resources\RiskReportResource\Pages;
use App\Filament\Resources\RiskReportResource\RelationManagers;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Tables\Filters\Filter;
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
                 ->dehydrated(false)
                 ->disabled(),
                 Forms\Components\Select::make('client_id')
                    ->relationship(name:'client', titleAttribute:'first_name')
                    ->searchable()
                    ->preload()
                    ->required(),
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

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('risk_number')
                    ->searchable(), 
                Tables\Columns\TextColumn::make('client.full_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('type'),
                Tables\Columns\TextColumn::make('date_rated'),
                Tables\Columns\TextColumn::make('pn_number'),
                Tables\Columns\TextColumn::make('branch.name'),
                Tables\Columns\TextColumn::make('applied_loan'),
            ])
            ->filters([ 
                
                Filter::make('created_at')
                            ->form([
                                Forms\Components\DatePicker::make('rated_from'),
                                Forms\Components\DatePicker::make('rated_until'),
                            ])
                            ->query(function (Builder $query, array $data): Builder {
                                return $query
                                    ->when(
                                        $data['rated_from'],
                                        fn (Builder $query, $date): Builder => $query->whereDate('date_rated', '>=', $date),
                                    )
                                    ->when(
                                        $data['rated_until'],
                                        fn (Builder $query, $date): Builder => $query->whereDate('date_rated', '<=', $date),
                                    );
                            }),
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
