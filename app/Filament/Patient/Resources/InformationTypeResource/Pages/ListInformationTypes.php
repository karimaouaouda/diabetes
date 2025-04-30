<?php

namespace App\Filament\Patient\Resources\InformationTypeResource\Pages;

use App\Filament\Patient\Resources\InformationTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListInformationTypes extends ListRecords
{
    protected static string $resource = InformationTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
