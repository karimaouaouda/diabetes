<?php

namespace App\Filament\Patient\Resources\DiabetesToolResource\Pages;

use App\Filament\Patient\Resources\DiabetesToolResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDiabetesTools extends ListRecords
{
    protected static string $resource = DiabetesToolResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
