<?php

namespace App\Filament\Patient\Pages;

use App\Models\Glycemie;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Filament\Forms\Contracts\HasForms;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Get;
use Filament\Forms\Set;

class SaisieGlycemie extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static string $view = 'filament.patient.pages.saisie-glycemie';
    protected static ?string $navigationLabel = 'Saisie glycémie';
    protected static ?string $title = 'Enregistrer une mesure';
    protected static ?string $slug = 'saisie-glycemie';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    // Fonction pour calculer la dose d'insuline basée sur la glycémie
    private function calculerInsuline(float $glycemie): float
    {
        // Paramètres de calcul d'insuline (à ajuster selon les besoins)
        $glycemie_cible = 5.5; // mmol/L
        $facteur_sensibilite = 2.0; // 1 unité d'insuline réduit la glycémie de 2 mmol/L

        if ($glycemie <= $glycemie_cible) {
            return 0; // Pas d'insuline nécessaire si la glycémie est au niveau cible ou en dessous
        }

        $insuline_necessaire = ($glycemie - $glycemie_cible) / $facteur_sensibilite;

        // Arrondir à 0.5 unité près
        return round($insuline_necessaire * 2) / 2;
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Repeater::make('mesures')
                    ->label('Mesures de glycémie')
                    ->schema([
                        Grid::make()
                            ->schema([
                                TextInput::make('valeur')
                                    ->label('Valeur (mmol/L)')
                                    ->numeric()
                                    ->required()
                                    ->step(0.1)
                                    ->live(debounce: 500)
                                    ->afterStateUpdated(function (Get $get, Set $set, $state) {
                                        if (!is_numeric($state) || empty($state)) {
                                            $set('insuline_calculee', null);
                                            return;
                                        }

                                        $glycemie = floatval($state);
                                        $insuline = $this->calculerInsuline($glycemie);
                                        $set('insuline_calculee', $insuline);
                                    }),

                                TextInput::make('insuline_calculee')
                                    ->label('Dose d\'insuline (unités)')
                                    ->numeric()
                                    ->step(0.5)
                                    ->disabled()
                                    ->helperText('Dose calculée automatiquement'),
                            ]),

                        Grid::make(2)
                            ->schema([
                                DatePicker::make('date_mesure')
                                    ->label('Date')
                                    ->required()
                                    ->default(now()),

                                TextInput::make('heure_mesure')
                                    ->label('Heure')
                                    ->type('time')
                                    ->required()
                                    ->default(now()->format('H:i')),
                            ]),

                        Select::make('moment')
                            ->label('Moment')
                            ->options([
                                'matin' => 'Matin',
                                'midi' => 'Avant déjeuner',
                                'soir' => 'Avant dîner',
                                'nuit' => 'Nuit',
                            ])
                            ->required(),

                        Textarea::make('commentaire')
                            ->label('Commentaire'),
                    ])
                    ->columns(1)
                    ->defaultItems(1) // Nombre initial de champs
                    ->addAction(
                        fn ($action) => $action
                            ->label('+Ajouter une autre mesure')
                    )
                    ->deleteAction(
                        fn ($action) => $action
                            ->label('Supprimer cette mesure')
                    )
                    ->reorderable(false) // Désactiver le réarrangement
                    ->collapsible() // Permettre de réduire les sections
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();

        foreach ($data['mesures'] as $mesure) {
            Glycemie::create([
                'patient_id' => Auth::id(),
                'valeur' => $mesure['valeur'],
                'insuline_calculee' => $mesure['insuline_calculee'] ?? null,
                'date_mesure' => $mesure['date_mesure'],
                'heure_mesure' => $mesure['heure_mesure'],
                'moment' => $mesure['moment'],
                'commentaire' => $mesure['commentaire'] ?? null,
            ]);
        }

        $this->form->fill(['mesures' => []]); // Réinitialiser le repeater
        $this->notify('success', count($data['mesures']) . ' mesures enregistrées !');
    }
}
