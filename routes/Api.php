<?php
use Illuminate\Support\Facades\Route;
use App\Filament\Patient\Pages\CalculInsuline;

Route::middleware(['auth:sanctum', 'patient'])
     ->post('/calculate-insulin', [CalculInsuline::class, 'apiCalculate']);
