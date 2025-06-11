<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Treatment extends Model
{
    /** @use HasFactory<\Database\Factories\TraitmentFactory> */
    use HasFactory;

    protected $fillable = [
        'doctor_id',
        'patient_id',
    ];


    public function patient() : BelongsTo
    {
        return $this->belongsTo(User::class, 'patient_id');
    }

    public function doctor(): BelongsTo
    {
        return$this->belongsTo(User::class, 'doctor_id');
    }

    public function medications(): BelongsToMany
    {
        return $this->belongsToMany(Medication::class, 'treatment_medications')
            ->withPivot([
                'times'
            ]);
    }

    public function medications_pivot(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(TreatmentMedication::class, 'treatment_id');
    }
}
