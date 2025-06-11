<?php

namespace App\Models;

use App\Observers\TreatmentMedicationObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;

#[ObservedBy(TreatmentMedicationObserver::class)]
class TreatmentMedication extends Model
{
    protected $table = 'treatment_medications';

    protected $fillable = [
        'treatment_id',
        'medication_id',
        'times',
        'start_date',
        'end_date'
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'times' => 'array',
    ];


    public function medication(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Medication::class);
    }

    public function treatment(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Treatment::class);
    }

}
