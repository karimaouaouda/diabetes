<?php

namespace App\Models;

//use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Workout extends Model
{
    protected $fillable = [
        'title',
        'description',
        'duration',      // Durée en minutes
        'difficulty',    // Débutant, Intermédiaire, Avancé
        'category',      // Cardio, Force, Flexibilité
        'user_id',       // Lien avec le patient (optionnel)
        'day_of_week',   // Lundi, Mardi...
        'calories_burned', // Calories estimées
        'equipment'      // Équipement requis
    ];

    // Relation avec l'utilisateur (si personnalisé par patient)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Convertir les champs spéciaux
    protected $casts = [
        'equipment' => 'array', // Stocker une liste JSON (ex: ["haltères", "tapis"])
        'day_of_week' => 'string'
    ];

    // Scopes pour filtrer facilement
    public function scopeForDifficulty($query, $level)
    {
        return $query->where('difficulty', $level);
    }

    public function scopeForCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    // Accesseur pour afficher la durée formatée
    public function getFormattedDurationAttribute()
    {
        return "{$this->duration} minutes";
    }

}
