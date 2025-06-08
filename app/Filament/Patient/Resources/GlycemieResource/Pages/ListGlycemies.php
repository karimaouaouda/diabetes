<?php

namespace App\Filament\Patient\Resources\GlycemieResource\Pages;

use App\Filament\Patient\Resources\GlycemieResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListGlycemies extends ListRecords
{
    protected static string $resource = GlycemieResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('add new measure'),
        ];
    }
}
