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

    public function form(Form $form): Form
{
    return $form
        ->schema([
            Repeater::make('mesures')
                ->label('Mesures de glycémie')
                ->schema([
                    TextInput::make('valeur')
                        ->label('Valeur (mmol/L)')
                        ->numeric()
                        ->required()
                        ->step(0.1),

                    DatePicker::make('date_mesure')
                        ->label('Date')
                        ->required()
                        ->default(now()),

                    TextInput::make('heure_mesure')
                        ->label('Heure')
                        ->type('time')
                        ->required()
                        ->default(now()->format('H:i')),

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
                ->columns(2)
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
