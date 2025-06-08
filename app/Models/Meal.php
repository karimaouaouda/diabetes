<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meal extends Model
{
    /** @use HasFactory<\Database\Factories\MealFactory> */
    use HasFactory;

    protected $fillable = [
        'admin_id',
        'name',
        'description',
        'image',
        'carbs'
    ];

    public float $threshold = 40;


    public function getLevelAttribute(): string
    {
        if( $this->attributes['carbs'] < $this->threshold )
            return 'Low';

        if ($this->attributes['carbs'] > $this->threshold && $this->attributes['carbs'] < ($this->threshold * 1.5))
            return 'Medium';

        return 'High';
    }

    public function admin(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}
