<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use App\Models\User;
use App\Models\Role;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Section;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Traits\HasRoles;
use Filament\Forms\Components\Select;
use Illuminate\Support\Facades\Auth;

class UserResource extends Resource
{
    
   
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
    $allowedRoles = ['Admin'];
    return Auth::user()?->roles()->whereIn('name', $allowedRoles)->exists() ?? false;
}
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    public static function getNavigationGroup(): ?string
{
    return 'Organization Management';
}

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Section::make('User Information')
                ->schema([
                    Forms\Components\TextInput::make('name')
                        ->label('Name')
                        ->maxLength(255),

                    Forms\Components\TextInput::make('email')
                        ->label('Email')
                        ->email()
                        ->maxLength(255),

                    Forms\Components\TextInput::make('password')
                        ->label('Password')
                        ->password()
                        ->revealable()
                        ->dehydrateStateUsing(fn ($state) => filled($state) ? Hash::make($state) : auth()->user()->password) // ✅ Keeps old password if empty
                        ->nullable()
                        ->same('password_confirmation'),

                    Forms\Components\TextInput::make('password_confirmation')
                        ->label('Confirm Password')
                        ->password()
                        ->revealable()
                        ->dehydrated(false)
                        ->nullable(),
                ]),

                Section::make('Roles')
                ->schema([
                    Select::make('roles')
                        ->label('Roles')
                        ->options(Role::pluck('name', 'id')->toArray()) // Ensure correct pluck format
                        ->multiple() // Allow multiple role selection
                        ->searchable()
                        ->preload() // Preload options for better performance
                        ->relationship('roles', 'name') // Ensure proper many-to-many relationship
                ]),
            
        ]);
}

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('email')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable()
                    ->sortable(),
                    Tables\Columns\TextColumn::make('roles.name')
                    ->searchable()
                    ->badge()
                    ->sortable(),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
