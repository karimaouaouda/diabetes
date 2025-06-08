<?php

namespace App\Filament\Patient\Resources\GlycemieResource\Pages;

use App\Filament\Patient\Resources\GlycemieResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditGlycemie extends EditRecord
{
    protected static string $resource = GlycemieResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
