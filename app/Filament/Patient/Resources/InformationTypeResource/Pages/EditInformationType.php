<?php

namespace App\Filament\Patient\Resources\InformationTypeResource\Pages;

use App\Filament\Patient\Resources\InformationTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditInformationType extends EditRecord
{
    protected static string $resource = InformationTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
