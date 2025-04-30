<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class medecin extends Model
{
    // Dans app/Models/Medecin.php
public function patients()
{
    return $this->belongsToMany(Patient::class, 'patient_medecin');
}

// Modifiez la query dans la page
->query(
    Glycemie::query()
        ->whereIn('patient_id', auth()->user()->patients()->pluck('id'))
        ->when($this->patientId, fn ($query) => $query->where('patient_id', $this->patientId))
)
}
