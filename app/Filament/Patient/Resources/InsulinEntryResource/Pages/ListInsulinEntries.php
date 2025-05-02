<?php

namespace App\Filament\Patient\Resources\InsulinEntryResource\Pages;

use App\Filament\Patient\Resources\InsulinEntryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListInsulinEntries extends ListRecords
{
    protected static string $resource = InsulinEntryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
