<?php

namespace App\Filament\Patient\Pages\Auth;

use Filament\Forms\Components\Hidden;
use Filament\Pages\Page;
use Filament\Pages\Auth\Register as FilamentRegister;

class PatientRegister extends FilamentRegister
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
            ->default('patient');
    }
}
