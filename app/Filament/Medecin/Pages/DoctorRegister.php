<?php

namespace App\Filament\Medecin\Pages;

use Filament\Forms\Components\Hidden;
use Filament\Pages\Auth\Register as FilamentRegister;

class DoctorRegister extends FilamentRegister
{
    protected function getForms(): array
    {
        return [
            'form' => $this->form(
                $this->makeForm()
                    ->schema([
                        $this->getRoleFormComponent(),
                        $this->getNameFormComponent(),
                        $this->getEmailFormComponent(),
                        $this->getPasswordFormComponent(),
                        $this->getPasswordConfirmationFormComponent(),
                    ])
                    ->statePath('data'),
            ),
        ];
    }

    private function getRoleFormComponent(): Hidden
    {
        return Hidden::make('role')
                    ->default('doctor');
    }
}
