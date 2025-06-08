<?php

namespace App\Filament\Patient\Resources\GlycemiesResource\Pages;

use App\Filament\Patient\Resources\GlycemiesResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditGlycemies extends EditRecord
{
    protected static string $resource = GlycemiesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
