<?php

namespace App\Filament\Patient\Resources;

use App\Models\Glycemies;
use App\Filament\Patient\Resources\GlycemieResource\Pages;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class GlycemieResource extends Resource
{
    protected static ?string $model = Glycemies::class;

    protected static ?string $navigationIcon = 'heroicon-o-heart';

    private static function calculerInsuline(float $glycemie): float
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

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Hidden::make('patient_id')
                    ->default(Auth::id()),
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
                        $insuline = static::calculerInsuline($glycemie);
                        $set('insuline_calculee', $insuline);
                    }),
                TextInput::make('insuline_calculee')
                    ->label('Dose d\'insuline (unités)')
                    ->numeric()
                    ->step(0.5)
                    ->disabled()
                    ->helperText('Dose calculée automatiquement'),
                DatePicker::make('date_mesure')
                    ->label('Date')
                    ->default(now())
                    ->required(),
                TextInput::make('heure_mesure')
                    ->label('Heure')
                    ->type('time')
                    ->required()
                    ->default(now()->format('H:i')),
                Select::make('moment')
                    ->label('Moment')
                    ->options([
                        'matin' => 'Matin',
                        'midi' => 'Avant dejeuner',
                        'soir' => 'Avant diner',
                        'nuit' => 'Nuit',
                    ])
                    ->required(),
                Textarea::make('commentaire')
                    ->label('Commentaire'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->badge()
                    ->prefix('#'),
                TextColumn::make('date_mesure')
                    ->label('Date')
                    ->date('d/m/Y')
                    ->sortable(),
                TextColumn::make('heure_mesure')
                    ->label('Heure'),
                TextColumn::make('valeur')
                    ->label('Valeur (mmol/L)')
                    ->color(fn(float $state) => match (true) {
                        $state < 4 => 'danger',
                        $state > 7 => 'warning',
                        default => 'success',
                    }),
                TextColumn::make('moment')
                    ->label('Moment')
                    ->badge(),
                TextColumn::make('commentaire')
                    ->label('Commentaire')
                    ->searchable()
                    ->limit(30),
            ])
            ->filters([
                SelectFilter::make('moment')
                    ->options([
                        'matin' => 'Matin',
                        'midi' => 'Avant dejeuner',
                        'soir' => 'Avant diner',
                        'nuit' => 'Nuit',
                    ]),
                Filter::make('date_mesure')
                    ->form([
                        DatePicker::make('from')->label('Du'),
                        DatePicker::make('until')->label('Au'),
                    ])
                    ->query(fn(Builder $query, array $data) => $query
                        ->when($data['from'] ?? null, fn(Builder $query, $date) => $query->whereDate('date_mesure', '>=', $date))
                        ->when($data['until'] ?? null, fn(Builder $query, $date) => $query->whereDate('date_mesure', '<=', $date))
                    ),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        return Glycemies::query()->where('patient_id', Auth::id());
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGlycemies::route('/'),
            'create' => Pages\CreateGlycemie::route('/create'),
            'edit' => Pages\EditGlycemie::route('/{record}/edit'),
        ];
    }
}
