<?php

use App\Enums\UserRoles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/patients', function(){
    return \App\Http\Resources\UserResource::collection(\App\Models\User::query()
        ->where('role', UserRoles::PATIENT->value)
        ->get());
});

Route::get('/patients/{patient}', function(\App\Models\User $patient){
    if( !$patient->isPatient() ){
        abort(404);
    }

    return \App\Http\Resources\UserResource::make($patient);
});


Route::get('/doctors', function () {
    return \App\Http\Resources\UserResource::collection(\App\Models\User::query()
        ->where('role', UserRoles::DOCTOR->value)
        ->get());
});


Route::get('/meals', function () {
    return \App\Http\Resources\MealResource::collection(\App\Models\Meal::all());
});
