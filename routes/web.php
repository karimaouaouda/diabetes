<?php

use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
    // Routes pour le calculateur d'insuline (groupe protégé par auth)
Route::middleware(['auth'])->prefix('patient')->name('patient.')->group(function () {
    // Page principale du calculateur
    Route::get('/insulin-calculator', [App\Http\Controllers\InsulinCalculatorController::class, 'index'])
        ->name('insulin.calculator');

    // Endpoint de calcul de la dose d'insuline
    Route::post('/insulin-calculator/calculate', [App\Http\Controllers\InsulinCalculatorController::class, 'calculate'])
        ->name('insulin.calculate');

    // Endpoint pour sauvegarder les paramètres du calculateur
    Route::post('/insulin-calculator/settings', [App\Http\Controllers\InsulinCalculatorController::class, 'saveSettings'])
        ->name('insulin.settings');

    // Endpoint pour obtenir l'historique des calculs
    Route::get('/insulin-calculator/history', [App\Http\Controllers\InsulinCalculatorController::class, 'getHistory'])
        ->name('insulin.history');
});
});
//Route::get('/profile', PatientProfile::class)->name('profile');

require __DIR__.'/auth.php';
