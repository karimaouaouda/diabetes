<?php

namespace App\Filament\Medecin\Resources\MedicationResource\Pages;

use App\Filament\Medecin\Resources\MedicationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMedications extends ListRecords
{
    protected static string $resource = MedicationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
