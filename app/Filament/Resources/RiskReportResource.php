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
use Filament\Actions\ExportAction;
use App\Filament\Exports\RiskReportExporter;
use Filament\Tables\Actions\ExportBulkAction;
use App\Models\Client;
use App\Models\Employee;
use Illuminate\Support\Facades\Auth;

class RiskReportResource extends Resource
{
    public static function getNavigationGroup(): ?string
    {
        return 'Credit Risk';
    }
    public static function canViewAny(): bool
        {
            return self::userHasAccess();
        }

        public static function canAccess(): bool
        {
            return self::userHasAccess();
        }

        private static function userHasAccess(): bool
        {
            $allowedRoles = ['Admin','Credit Risk', 'IT Risk', 'Ops Risk'];
            return Auth::user()?->roles()->whereIn('name', $allowedRoles)->exists() ?? false;
        }

        public static function canEdit($record): bool
        {
            return Auth::user()?->roles()->whereIn('name', ['Admin', 'Credit Risk'])->exists() ?? false;
        }

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
                    ->label('Client Name')
                    ->required()
                    ->options(Client::query()->get()->pluck('full_name', 'id')),
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
                    ->relationship(name:'branch', titleAttribute:'branch_name')
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
                    Forms\Components\Select::make('requested_by')
                    ->label('Requested By')
                    ->options(Employee::all()->pluck('name', 'id'))
                    ->searchable()
                    ->preload()
                    ->nullable(),
                
                Forms\Components\Select::make('assessed_by.name')
                    ->label('Assessed By')
                    ->options(Employee::all()->pluck('name', 'id'))
                    ->searchable()
                    ->preload()
                    ->nullable(),                
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
                Tables\Columns\TextColumn::make('client.full_name'),
                Tables\Columns\TextColumn::make('branch.branch_name')
                ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('date_rated')
                ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('next_review_date')
                ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('employee.employee_name')
                ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('assessed_by')
                ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('applied_loan')
                ->formatStateUsing(fn ($state) => number_format($state, 2))
                ->toggleable(isToggledHiddenByDefault: true),
            
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
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),

            ])
            ->headerActions([
                Tables\Actions\ExportAction::make()->exporter(RiskReportExporter::class),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                Tables\Actions\DeleteBulkAction::make(),
                ]),
                ExportBulkAction::make()->exporter(RiskReportExporter::class),
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
            'view' => Pages\ViewRiskReport::route('/{record}'),
            'edit' => Pages\EditRiskReport::route('/{record}/edit'),
        ];
    }
}
