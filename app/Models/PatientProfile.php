<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PatientProfile extends Model
{
    protected $fillable = [
        'patient_id',
        'blood_type',
        'height',
        'weight',
        'meals',
        'allergies'
    ];

    protected $casts = [
        'meals' => 'array',
    ];
    public function patient(): BelongsTo
    {
        return $this->belongsTo(User::class, 'patient_id');
    }
}
