<?php

namespace App\Filament\Medecin\Resources\MedicationResource\Pages;

use App\Filament\Medecin\Resources\MedicationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMedication extends EditRecord
{
    protected static string $resource = MedicationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
