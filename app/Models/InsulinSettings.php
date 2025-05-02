<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InsulinSettings extends Model
{
    use HasFactory;

    /**
     * Les attributs qui sont assignables en masse.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'target_glucose',
        'correction_factor',
        'carb_ratio',
        'insulin_duration',
        'active_insulin_time',
    ];

    /**
     * Obtenir l'utilisateur associé à ces paramètres.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

