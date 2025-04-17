<?php

// app/Models/DoseInsuline.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoseInsuline extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'dose',
        'details',
        'date_heure'
    ];

    protected $casts = [
        'details' => 'array',
        'date_heure' => 'datetime'
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
