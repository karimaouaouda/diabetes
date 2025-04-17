<?php

namespace App\Filament\Medecin\Pages;

use App\Models\Patient;
use App\Models\Glycemie;
use Filament\Forms\Components\Select;
use Filament\Pages\Page;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class PatientGlycemieHistory extends Page implements HasTable
{
    use InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-heart';
    protected static string $view = 'filament.medecin.pages.patient-glycemie-history';
    protected static ?string $navigationLabel = 'Historique Glycémique Patient';
    protected static ?string $title = 'Suivi Glycémique des Patients';
    protected static ?string $slug = 'patient-glycemie-history';

    public $patientId;

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Glycemie::query()
                    ->when($this->patientId, fn ($query) => $query->where('patient_id', $this->patientId)))
            ->columns([
                TextColumn::make('date_mesure')
                    ->label('Date')
                    ->date('d/m/Y')
                    ->sortable(),
                TextColumn::make('heure_mesure')
                    ->label('Heure'),
                TextColumn::make('valeur')
                    ->label('Valeur (mmol/L)')
                    ->color(fn (float $state) => match (true) {
                        $state < 4 => 'danger',
                        $state > 7 => 'warning',
                        default => 'success'
                    }),
                TextColumn::make('moment')
                    ->label('Moment')
                    ->badge()
                    ->color(fn (string $state) => match ($state) {
                        'matin' => 'primary',
                        'midi' => 'warning',
                        'soir' => 'gray',
                        'nuit' => 'dark',
                    }),
                TextColumn::make('commentaire')
                    ->label('Commentaire')
                    ->limit(30),
            ])
            ->filters([
                // Filtres optionnels
            ])
            ->actions([
                // Actions optionnelles
            ])
            ->bulkActions([
                // Actions groupées
            ]);
        }

    protected function getFormSchema(): array
    {
        return [
            Select::make('patientId')
                ->label('Sélectionner un patient')
                ->options(Patient::all()->pluck('name', 'id'))
                ->searchable()
                ->required()
                ->reactive()
                ->afterStateUpdated(fn () => $this->resetTable()),
        ];
    }
    // Dans app/Filament/Medecin/Pages/PatientGlycemieHistory.php

public function getGlycemieDates(): array
{
    return Glycemie::where('patient_id', $this->patientId)
        ->orderBy('date_mesure')
        ->get()
        ->map(fn ($item) => $item->date_mesure->format('d/m/Y'))
        ->toArray();
}

public function getGlycemieValues(): array
{
    return Glycemie::where('patient_id', $this->patientId)
        ->orderBy('date_mesure')
        ->pluck('valeur')
        ->toArray();
}

protected function getListeners(): array
{
    return [
        'patientChanged' => 'render',
    ];
}

public function updatedPatientId(): void
{
    $this->dispatch('patientChanged');
}
}
