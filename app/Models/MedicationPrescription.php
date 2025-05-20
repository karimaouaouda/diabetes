<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MedicationPrescription extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'medication_id',
        'date_prise',
        'heure_prise',
        'quantite',
        'instructions',
        'statut',
        'notes',
    ];

    protected $casts = [
        'date_prise' => 'date',
        'heure_prise' => 'datetime',
    ];

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    public function medication(): BelongsTo
    {
        return $this->belongsTo(Medication::class);
    }
}
