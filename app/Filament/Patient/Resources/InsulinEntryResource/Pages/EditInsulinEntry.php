<?php

namespace App\Filament\Patient\Resources\InsulinEntryResource\Pages;

use App\Filament\Patient\Resources\InsulinEntryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditInsulinEntry extends EditRecord
{
    protected static string $resource = InsulinEntryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
