<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
class Patient extends Authenticatable
{
    public function glycemies()
{
    return $this->hasMany(Glycemie::class);
}
public function dosesInsuline()
{
    return $this->hasMany(DoseInsuline::class);
}

public function consultations()
{
    return $this->hasMany(Consultation::class);
}
public function medecin()
{
    return $this->hasMany(medecin::class);
}
// Model Patient.php



}
