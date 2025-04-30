<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TodoItem extends Model
{
    use HasFactory;

    /**
     * Les attributs remplissables (mass assignable).
     */
    protected $fillable = [
        'task',         // Description de la tâche
        'due_date',      // Date d'échéance
        'completed',     // Statut de complétion
        'user_id',       // Lien vers le patient

    ];

    /**
     * Relation avec le modèle User (Patient).
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Formatage des dates.
     */
    protected $casts = [
        'due_date' => 'datetime',  // Convertit due_date en objet Carbon
        'completed' => 'boolean',  // Convertit completed en booléen
    ];

    /**
     * Accesseur pour le statut formaté.
     */
    public function getStatusAttribute()
    {
        return $this->completed ? '✅ Terminé' : '🕒 En attente';
    }

    /**
     * Scope pour filtrer les tâches actives.
     */
    public function scopeIncomplete($query)
    {
        return $query->where('completed', false);
    }
}
