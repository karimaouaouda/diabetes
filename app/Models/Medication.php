<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Medication extends Model
{
    // app/Models/Medication.php
    protected $casts = [
        'times' => 'array',
        'start_date' => 'date',
        'end_date' => 'date'
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
