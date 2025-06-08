<?php

namespace App\Filament\Patient\Resources\GlycemiesResource\Pages;

use App\Filament\Patient\Resources\GlycemiesResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListGlycemies extends ListRecords
{
    protected static string $resource = GlycemiesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
