<?php

namespace App\Filament\Patient\Pages;

use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Forms\Contracts\HasForms;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class CalculInsuline extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-calculator';
    protected static string $view = 'filament.patient.pages.calcul-insuline';
    protected static ?string $navigationLabel = 'Calcul d\'insuline';
    protected static ?string $title = 'Calculateur de dose d\'insuline';
    protected static ?string $slug = 'calcul-insuline';

    public ?array $data = [];
    public ?float $doseInsuline = null;

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Fieldset::make('Détails du repas')
                ->schema([
                    TextInput::make('glucides')
                        ->label('Glucides (g)')
                        ->numeric()
                        ->required(),

                    TextInput::make('quantité')
                        ->label('Quantité (g)')
                        ->numeric()
                        ->required(),
                ])->columns(2),
                Fieldset::make('Détails du repas')
                    ->schema([
                        TextInput::make('glucides')
                            ->label('Glucides (g)')
                            ->numeric()
                            ->required(),

                        TextInput::make('proteines')
                            ->label('Protéines (g)')
                            ->numeric()
                            ->required(),

                        TextInput::make('lipides')
                            ->label('Lipides (g)')
                            ->numeric()
                            ->required(),
                    ])->columns(3),



                Fieldset::make('Paramètres actuels')
                    ->schema([
                        TextInput::make('glycemie_avant')
                            ->label('Glycémie avant repas (mmol/L)')
                            ->numeric()
                            ->required()
                            ->step(0.1),

                        TextInput::make('ratio_insuline')
                            ->label('Ratio insuline/glucides')
                            ->numeric()
                            ->required()
                            ->default(1)
                            ->step(0.1),

                        TimePicker::make('heure_repas')
                            ->label('Heure du repas')
                            ->required()
                            ->default(now()),
                    ])->columns(3),
            ])
            ->statePath('data');
    }

    public function calculerDose(): void
    {
        $data = $this->form->getState();

        try {
            // Appel à l'API de calcul
            $response = Http::post('https://api-votre-service.com/calcul-insuline', [
                'glucides' => $data['glucides'],
                'proteines' => $data['proteines'],
                'lipides' => $data['lipides'],
                'glycemie' => $data['glycemie_avant'],
                'ratio' => $data['ratio_insuline'],
                'patient_id' => Auth::id()]);

            if ($response->successful()) {
                $this->doseInsuline = $response->json()['dose_insuline'];

                Notification::make()
                    ->title('Calcul réussi')
                    ->success()
                    ->send();
            } else {
                throw new \Exception('Erreur API');
            }
        } catch (\Exception $e) {
            Notification::make()
                ->title('Erreur de calcul')
                ->danger()
                ->body($e->getMessage())
                ->send();
        }
    }

    public function enregistrer(): void
    {
        if (!$this->doseInsuline) {
            Notification::make()
                ->title('Veuillez d\'abord calculer la dose')
                ->warning()
                ->send();
            return;
        }

        try {
            // Enregistrement dans la base de données
            Auth::user()->dosesInsuline()->create([
                'dose' => $this->doseInsuline,
                'details' => $this->form->getState(),
                'date_heure' => now(),
            ]);

            Notification::make()
                ->title('Dose enregistrée avec succès')
                ->success()
                ->send();

            $this->reset('doseInsuline');
            $this->form->fill();

        } catch (\Exception $e) {
            Notification::make()
                ->title('Erreur d\'enregistrement')
                ->danger()
                ->body($e->getMessage())
                ->send();
        }
    }
}
