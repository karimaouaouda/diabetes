<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InsulinCalculation extends Model
{
    use HasFactory;

    /**
     * Les attributs qui sont assignables en masse.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'blood_glucose',
        'carbohydrates',
        'meal_type',
        'correction_units',
        'meal_units',
        'total_units',
        'physical_activity',
        'notes',
    ];

    /**
     * Les attributs qui doivent être castés.
     *
     * @var array
     */
    protected $casts = [
        'blood_glucose' => 'float',
        'carbohydrates' => 'float',
        'correction_units' => 'float',
        'meal_units' => 'float',
        'total_units' => 'float',
        'created_at' => 'datetime',
    ];

    /**
     * Obtenir l'utilisateur associé à ce calcul.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
