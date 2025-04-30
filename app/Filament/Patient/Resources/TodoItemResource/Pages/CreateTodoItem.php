<?php

namespace App\Filament\Patient\Resources\TodoItemResource\Pages;

use App\Filament\Patient\Resources\TodoItemResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateTodoItem extends CreateRecord
{
    protected static string $resource = TodoItemResource::class;
}
