<?php

namespace App\Filament\Medecin\Pages;

use App\Models\User;
use App\Models\Glycemie;
use Filament\Pages\Page;

class PatientAnalytics extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';

    protected static string $view = 'filament.medecin.pages.patient-analytics';

    protected static ?string $title = 'Analyse patient';

    protected static ?string $slug = 'patient-analytics';

    protected static bool $shouldRegisterNavigation = false;

    public User $patient;

    public function mount(int $record): void
    {
        $this->patient = User::with('patientProfile')->findOrFail($record);
    }

    public function getGlycemiesProperty()
    {
        return Glycemie::where('patient_id', $this->patient->id)
            ->orderByDesc('date_mesure')
            ->orderByDesc('heure_mesure')
            ->take(10)
            ->get();
    }

}
