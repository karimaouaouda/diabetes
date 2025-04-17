<?php

namespace App\Filament\Patient\Pages;

use Filament\Pages\Page;

class PatientProfile extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.patient.pages.patient-profile';
}
