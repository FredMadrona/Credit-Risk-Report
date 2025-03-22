<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EmployeeResource\Pages;
use App\Filament\Resources\EmployeeResource\RelationManagers;
use App\Models\Employee;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Section;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Support\Facades\Auth;

class EmployeeResource extends Resource
{
    protected static ?string $model = Employee::class;

    protected static ?string $navigationIcon = 'heroicon-o-briefcase';

    public static function getNavigationGroup(): ?string
{
    return 'Organization Management';
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
                return Auth::user()?->roles()->whereIn('name', ['Admin', 'Ops Risk'])->exists() ?? false;
            }

            public static function form(Form $form): Form
            {
                return $form
                    ->schema([
                        Section::make('Basic Information')
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->label('Name')
                                    ->required()
                                    ->maxLength(255)
                            ])                     
                            ->collapsible(),

                        Section::make('Work Details')
                            ->schema([
                                Forms\Components\Select::make('branch_id')
                                    ->label('Branch')
                                    ->relationship('branch', 'branch_name')
                                    ->searchable()
                                    ->preload()
                                    ->required()
                                    ->createOptionForm([
                                        Forms\Components\TextInput::make('name')
                                            ->label('Branch Name')
                                            ->required()
                                            ->maxLength(255),
                                    ]),
                
            
                                Forms\Components\Select::make('department_id')
                                    ->label('Department')
                                    ->relationship('department', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->required()
                                    ->createOptionForm([
                                        Forms\Components\TextInput::make('name')
                                            ->label('Department Name')
                                            ->required()
                                            ->maxLength(255),
                                    ])
                            ])
                             ->collapsed() ->columns(2),
            
                        Section::make('Employment Status')
                            ->schema([
                                Forms\Components\Select::make('employee_status')
                                    ->label('Employee Status')
                                    ->required()
                                    ->options([
                                        'Active' => 'Active',
                                        'Resigned' => 'Resigned',
                                        'Retired' => 'Retired',
                                    ])
                                
                            ])
                             ->collapsed(),
            
                        Section::make('Job Information')
                            ->schema([
                                Forms\Components\Select::make('job_position')
                                    ->label('Job Position')
                                    ->required()
                                    ->options([
                                        'Associate' => 'Associate',
                                        'Department Head' => 'Department Head',
                                        'CEO' => 'CEO',
                                        'COO' => 'COO',
                                        'Vice President' => 'Vice President',
                                        'Deputy Head' => 'Deputy Head',
                                        'Area Head' => 'Area Head',
                                        'Unit Head' => 'Unit Head',
                                    ])
                                
                            ])     ->collapsed(),
            
                        Section::make('Important Dates')
                            ->schema([
                                Forms\Components\DatePicker::make('birth_date')
                                    ->label('Birth Date')
                                    ->required(),
            
                                Forms\Components\DatePicker::make('date_regularized')
                                    ->label('Date Regularized')
                                    ->required(),
            
                                Forms\Components\DatePicker::make('hire_date')
                                    ->label('Hire Date')
                                    ->required()
                            ])     ->collapsed() ->columns(3),
                    ]);
            }            

    public static function table(Table $table): Table
    {
        return $table
        ->columns([
            Tables\Columns\TextColumn::make('name')
            ->searchable(),
            Tables\Columns\TextColumn::make('employee_status')
            ->badge()
            ->searchable()
            ->color(fn (string $state): string => match ($state) {
                'Active' => 'success',
                'Resigned' => 'danger',
                'Retired' => 'warning',
                default => 'primary',
            }),
            Tables\Columns\TextColumn::make('branch.branch_name')
                ->toggleable(isToggledHiddenByDefault: true),
            Tables\Columns\TextColumn::make('department.name')
                ->toggleable(isToggledHiddenByDefault: true),
            Tables\Columns\TextColumn::make('job_position')
                ->searchable()
                ->toggleable(isToggledHiddenByDefault: true),
            Tables\Columns\TextColumn::make('birth_date')
                ->searchable()
                ->toggleable(isToggledHiddenByDefault: true),
            Tables\Columns\TextColumn::make('date_regularized')
                ->searchable()
                ->toggleable(isToggledHiddenByDefault: true),
        ])
            ->filters([
               SelectFilter::make('employee_status')
                    ->options([
                        'Active' => 'Active',
                        'Resigned' => 'Resigned',
                        'Retired' => 'Retired',
                    ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListEmployees::route('/'),
            'create' => Pages\CreateEmployee::route('/create'),
            'view' => Pages\ViewEmployee::route('/{record}'),
            'edit' => Pages\EditEmployee::route('/{record}/edit'),
        ];
    }
}
