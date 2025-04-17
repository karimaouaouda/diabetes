<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Glycemie extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'patient_id',
        'valeur',
        'date_mesure',
        'heure_mesure',
        'moment',
        'commentaire'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'date_mesure' => 'date',
        'heure_mesure' => 'datetime:H:i',
    ];
    protected $attributes = [
        'date_mesure' => null,
        'heure_mesure' => null,
    ];
    /**
     * Relation avec le patient
     */
    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    /**
     * Règles de validation
     */
    public static function rules(): array
    {
        return [
            'valeur' => ['required', 'numeric', 'min:0.1', 'max:30'],
            'date_mesure' => ['required', 'date', 'before_or_equal:today'],
            'heure_mesure' => ['required', 'date_format:H:i'],
            'moment' => [
                'required',
                Rule::unique('glycemies')
                    ->where('patient_id', Auth()->id())
                    ->where('date_mesure', request()->input('date_mesure'))
            ],
        ];
    }

    /**
     * Scopes utiles
     */
    public function scopeForToday($query)
    {
        return $query->whereDate('date_mesure', today());
    }

    public function scopeByMoment($query, $moment)
    {
        return $query->where('moment', $moment);
    }

    /**
     * Formatage personnalisé
     */
    public function getFormattedDateAttribute(): string
    {
        return $this->date_mesure->format('d/m/Y');
    }

    public function getFormattedTimeAttribute(): string
    {
        return $this->heure_mesure->format('H\hi');
    }
}
