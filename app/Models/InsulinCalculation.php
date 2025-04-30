<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InsulinCalculation extends Model
{
    use HasFactory;

    protected $fillable = [
        'current_glucose',
        'carbs',
        'carb_ratio',
        'insulin_sensitivity',
        'target_glucose',
        'calculated_dose',
    ];
}
