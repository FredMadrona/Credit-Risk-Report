<?php

namespace App\Filament\Pages\Auth;

use Filament\Pages\Auth\Registration as BaseRegistration;
use Illuminate\Support\Str;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;

class UserRegistration extends BaseRegistration
{
    protected function getForm(): Form
    {
        return Form::make()
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->label('Name'),

                TextInput::make('email')
                    ->required()
                    ->email()
                    ->endsWith('@example.com')
                    ->unique('users', 'email')
                    ->label('Email'),

                TextInput::make('password')
                    ->required()
                    ->password()
                    ->label('Password'),

                TextInput::make('passwordConfirmation')
                    ->required()
                    ->password()
                    ->label('Confirm Password')
                    ->same('password'),
            ]);
    }
}
