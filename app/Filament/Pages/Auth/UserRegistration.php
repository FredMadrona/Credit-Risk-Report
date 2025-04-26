<?php

namespace App\Filament\Pages\Auth;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\Auth\Register as BaseRegistration;



class UserRegistration extends BaseRegistration
{
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                $this->getNameFormComponent(), 
                $this->getEmailFormComponent()
                    ->required()
                    ->email()
                    ->rule('ends_with:@example.com'), 
                $this->getPasswordFormComponent(),
                $this->getPasswordConfirmationFormComponent(),
            ]);
    }
}
