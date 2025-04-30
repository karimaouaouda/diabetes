<?php

namespace App\Filament\Patient\Resources\TodoItemResource\Pages;

use App\Filament\Patient\Resources\TodoItemResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTodoItem extends EditRecord
{
    protected static string $resource = TodoItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
