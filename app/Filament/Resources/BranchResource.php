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

class BranchResource extends Resource
{
    protected static ?string $model = Branch::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office';

    public static function getNavigationGroup(): ?string
{
    return 'Organization Management';
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
                ->relationship('manager', 'name') 
                ->searchable()
                ->preload()
                ->nullable(),
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
                ->sortable()
                ->searchable(),

            Tables\Columns\TextColumn::make('branch_address')
                ->label('Address')
                ->sortable()
                ->searchable(),

            Tables\Columns\TextColumn::make('branch_phone')
                ->label('Phone Number')
                ->sortable(),

            Tables\Columns\TextColumn::make('branch_email')
                ->label('Email Address')
                ->sortable(),
            Tables\Columns\TextColumn::make('branch_manager')
                ->label('Branch Manager')
                ->sortable()
                ->searchable(),            

            Tables\Columns\TextColumn::make('created_at')
                ->label('Created At')
                ->dateTime('M d, Y H:i')
                ->sortable(),
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
