<?php

namespace App\Filament\Patient\Resources\InsulinEntryResource\Pages;

use App\Filament\Patient\Resources\InsulinEntryResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;

// app/Filament/Resources/InsulinEntryResource/Pages/CreateInsulinEntry.php
use Filament\Pages\Actions\Action;
use Filament\Resources\Pages\Page;

class CreateInsulinEntry extends CreateRecord
{
    protected static string $resource = InsulinEntryResource::class;

    public $blood_glucose;
    public $carbs;
    public $correction_units;
    public $meal_units;
    public $total_bolus;

    protected function getFormSchema(): array
    {
        return [
            Card::make()
                ->schema([
            DatePicker::make('date')
                        ->default(now()),
            TextInput::make('blood_glucose')
                        ->reactive()
                        ->afterStateUpdated(fn ($state) => $this->calculateInsulin()),
            TextInput::make('carbs')
                        ->reactive()
                        ->afterStateUpdated(fn ($state) => $this->calculateInsulin()),
                ]),

            Card::make()
                ->schema([
                    TextInput::make('correction_units')
                        ->disabled(),
                    TextInput::make('meal_units')
                        ->disabled(),
                    TextInput::make('total_bolus')
                        ->disabled(),
                ]),
        ];
    }

    protected function calculateInsulin()
    {
        $userSettings = auth()->user()->settings;

        // Correction Units
        $excess = $this->blood_glucose - $userSettings->target_bgl;
        $this->correction_units = $excess > 0
            ? round($excess / $userSettings->correction_ratio, 1)
            : 0;

        // Meal Units
        $this->meal_units = round($this->carbs / $userSettings->carbs_ratio, 1);

        // Total
        $this->total_bolus = $this->correction_units + $this->meal_units;
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();
        $data['correction_units'] = $this->correction_units;
        $data['meal_units'] = $this->meal_units;
        $data['total_bolus'] = $this->total_bolus;

        return $data;
    }
}
