<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// app/Models/InsulinEntry.php
class InsulinEntry extends Model
{
    protected $fillable = [
        'user_id', 'date', 'blood_glucose', 'carbs',
        'correction_units', 'meal_units', 'total_bolus'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

// app/Models/UserSetting.php
class UserSetting extends Model
{
    protected $fillable = ['target_bgl', 'correction_ratio', 'carbs_ratio'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
