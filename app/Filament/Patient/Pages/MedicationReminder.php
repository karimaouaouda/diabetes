<?php

namespace App\Filament\Patient\Pages;

use Filament\Pages\Page;
use Filament\Forms\Form;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Collection; // Ajouter en haut
use App\Models\Medication;
use Filament\Notifications\Notification;

class MedicationReminder extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.patient.pages.medication-reminder';
    public Collection $medications; // Déclaration typée

    public function mount(): void
    {
        $this->medications = new Collection(); // Initialisation vide
    }

    public function form(Form $form): Form
{
    return $form
        ->schema([
            TextInput::make('name')
                ->required()
                ->label('Nom du médicament'),

            TextInput::make('dosage')
                ->required()
                ->label('Dosage'),

            Repeater::make('times')
                ->label('Heures de prise')
                ->schema([
                    TimePicker::make('time')
                        ->required()
                        ->seconds(false)
                ])
                ->columns(3),

            DatePicker::make('start_date')
                ->required()
                ->label('Date de début'),

            DatePicker::make('end_date')
                ->label('Date de fin (optionnel)'),

            Toggle::make('notifications_enabled')
                ->default(true)
                ->label('Activer les rappels')
        ]);
}

public function save(): void
{
    $data = $this->form->getState();

    auth()->user()->medications()->create([
        'name' => $data['name'],
        'dosage' => $data['dosage'],
        'times' => collect($data['times'])->pluck('time'),
        'start_date' => $data['start_date'],
        'end_date' => $data['end_date'],
        'notifications_enabled' => $data['notifications_enabled']
    ]);

    $this->notify('success', 'Médicament enregistré avec rappels activés');
}
//use App\Models\Medication;
//use Filament\Notifications\Notification;

public function deleteMedication($id): void
{
    try {
        $medication = Medication::findOrFail($id);
        $medication->delete();

        // Recharger les médicaments après suppression
        $this->loadMedications();

        Notification::make()
            ->title('Suppression réussie')
            ->success()
            ->body('Le médicament a été supprimé avec succès')
            ->send();

    } catch (\Exception $e) {
        Notification::make()
            ->title('Erreur')
            ->danger()
            ->body('Impossible de supprimer le médicament: ' . $e->getMessage())
            ->send();
    }
}

protected function getListeners(): array
{
    return [
        'medicationTaken' => 'markAsTaken',
        'refreshMedications' => '$refresh', // Ajouter le rafraîchissement automatique
    ];
}

public function markAsTaken($medicationId): void
{
    try {
        $medication = Medication::findOrFail($medicationId);
        $medication->update([
            'last_taken' => now(),
            'next_reminder' => $medication->calculateNextReminder() // Méthode à implémenter
        ]);

        // Rafraîchir les données
        $this->loadMedications();

        Notification::make()
            ->title('Prise enregistrée')
            ->success()
            ->body('La prise a été enregistrée à ' . now()->format('H:i'))
            ->send();

    } catch (\Exception $e) {
        Notification::make()
            ->title('Erreur')
            ->danger()
            ->body('Impossible d\'enregistrer la prise: ' . $e->getMessage())
            ->send();
    }
}

// Méthode pour charger les médicaments
public function loadMedications(): void
{
    $this->medications = auth()->user()
        ->medications()
        ->orderBy('next_reminder')
        ->get();
}

// Initialiser au chargement

}
