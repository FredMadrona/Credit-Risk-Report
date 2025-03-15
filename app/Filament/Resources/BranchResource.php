<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BranchResource\Pages;
use App\Filament\Resources\BranchResource\RelationManagers;
use App\Models\Branch;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Models\Employee;
use Illuminate\Support\Facades\Auth;

class BranchResource extends Resource
{
    protected static ?string $model = Branch::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office';

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
            Forms\Components\TextInput::make('branch_name')
                ->label('Branch Name')
                ->required()
                ->maxLength(255),

            Forms\Components\TextInput::make('branch_code')
                ->label('Branch Code')
                ->required()
                ->maxLength(10),

            Forms\Components\TextInput::make('branch_address')
                ->label('Address')
                ->required(),

            Forms\Components\TextInput::make('branch_phone')
                ->label('Phone Number')
                ->tel()
                ->maxLength(20),

            Forms\Components\TextInput::make('branch_email')
                ->label('Email Address')
                ->email()
                ->maxLength(255),

                Forms\Components\Select::make('branch_manager_id')
                ->label('Branch Manager')
                ->options(Employee::all()->pluck('name', 'id'))
                ->searchable()
                ->required(),                
        ]);
}


public static function table(Table $table): Table
{
    return $table
        ->columns([
            Tables\Columns\TextColumn::make('branch_name')
                ->label('Branch Name')
                ->sortable()
                ->searchable(),

            Tables\Columns\TextColumn::make('branch_code')
                ->label('Branch Code')
                ->toggleable(isToggledHiddenByDefault: true)
                ->sortable()
                ->searchable(),

            Tables\Columns\TextColumn::make('branch_address')
                ->label('Address')
                ->toggleable(isToggledHiddenByDefault: true)
                ->sortable()
                ->searchable(),

            Tables\Columns\TextColumn::make('branch_phone')
                ->label('Phone Number')
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
            Tables\Columns\TextColumn::make('branch_email')
                ->label('Email Address')
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
            Tables\Columns\TextColumn::make('manager.name') 
                ->label('Branch Manager')
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true)
                ->searchable(),
                      
        ])
            ->filters([
                        //
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

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBranches::route('/'),
            'create' => Pages\CreateBranch::route('/create'),
            'edit' => Pages\EditBranch::route('/{record}/edit'),
        ];
    }
}
