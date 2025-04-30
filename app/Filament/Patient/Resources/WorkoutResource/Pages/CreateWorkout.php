<?php

namespace App\Filament\Patient\Resources\WorkoutResource\Pages;

use App\Filament\Patient\Resources\WorkoutResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateWorkout extends CreateRecord
{
    protected static string $resource = WorkoutResource::class;
}
