<?php

namespace App\Filament\Pages\Auth;

use Filament\Forms\Components\TextInput;
use Filament\Auth\Pages\Register as BaseRegister;
use Filament\Schemas\Schema;

class Register extends BaseRegister
{
    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                $this->getNameFormComponent(),
                $this->getEmailFormComponent(),
                
                // OUR CUSTOM WHATSAPP FIELD!
                TextInput::make('phone')
                    ->label('WhatsApp Number')
                    ->placeholder('e.g., 08012345678')
                    ->helperText('This must be your active WhatsApp number.')
                    ->required()
                    ->tel()
                    ->maxLength(255),
                    
                $this->getPasswordFormComponent(),
                $this->getPasswordConfirmationFormComponent(),
            ]);
    }
}
