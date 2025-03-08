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
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EmployeeResource extends Resource
{
    protected static ?string $model = Employee::class;

    protected static ?string $navigationIcon = 'heroicon-o-briefcase';

    public static function getNavigationGroup(): ?string
{
    return 'Organization Management';
}


    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Forms\Components\TextInput::make('name')
                ->label('Name')
                ->required()
                ->maxLength(255),
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
                    Forms\Components\Select::make('department_id')
                    ->relationship('department', 'name')
                    ->searchable()
                    ->preload()
                    ->createOptionForm([
                        Forms\Components\TextInput::make('name')
                            ->label('Name')
                            ->required()
                            ->maxlength(255) 
                    ]),

                    Forms\Components\Select::make('employee_type')
                    ->required()
                    ->options([
                    'Regular' => 'Regular',
                    'Contractual' => 'Contractual',
                    'Probationary' => 'Probationary',   
                ]),
                Forms\Components\Select::make('job_position')
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
                'Vice President' => 'Vice President',

            ]),
            Forms\Components\DatePicker::make('birth_date')->required(),
            Forms\Components\DatePicker::make('hire_date')->required(),
        ]);    }

    public static function table(Table $table): Table
    {
        return $table
        ->columns([
            Tables\Columns\TextColumn::make('name')
            ->searchable(),
            Tables\Columns\TextColumn::make('employee_type'),
            Tables\Columns\TextColumn::make('branch.name'),
            Tables\Columns\TextColumn::make('department.name'),
            Tables\Columns\TextColumn::make('job_position')->searchable(),
        ])
            ->filters([
               //
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
