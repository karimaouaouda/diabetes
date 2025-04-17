<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
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
}
