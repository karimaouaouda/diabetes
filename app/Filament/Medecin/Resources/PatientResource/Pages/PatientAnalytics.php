<?php

namespace App\Filament\Medecin\Resources\PatientResource\Pages;

use App\Filament\Medecin\Resources\PatientResource;
use App\Filament\Medecin\Widgets\PatientGlycemieChart;
use App\Models\Glycemies;
use App\Models\User;
use Filament\Resources\Pages\ViewRecord;

class PatientAnalytics extends ViewRecord
{
    protected static string $resource = PatientResource::class;
    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';

    protected static string $view = 'filament.medecin.pages.patient-analytics';

    protected static ?string $title = 'Analyse patient';

    protected static ?string $slug = 'patient-analytics';

    protected static bool $shouldRegisterNavigation = false;

    protected function getHeaderWidgets(): array
    {
        return [
            PatientGlycemieChart::make([
                'patient_id' => $this->record->id
            ])
        ];
    }

    public function mount(int|string $record): void
    {
        $this->record = User::query()->findOrFail($record);

        $this->authorizeAccess();

        if (! $this->hasInfolist()) {
            $this->fillForm();
        }

    }

    public function getModel(): string
    {
        return User::class;
    }

    public function getGlycemiesProperty()
    {
        return Glycemies::where('patient_id', $this->record->id)
            ->orderByDesc('date_mesure')
            ->orderByDesc('heure_mesure')
            ->take(10)
            ->get();
    }
}
