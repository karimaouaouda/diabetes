<?php

namespace App\Filament\Patient\Pages;

use Filament\Pages\Page;
use App\Models\DiabetesTool;

class PatientDiabetesTools extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.patient.pages.patient-diabetes-tools';
    public function tools()
{
    return DiabetesTool::all();
}
}
