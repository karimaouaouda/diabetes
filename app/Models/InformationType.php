<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InformationType extends Model
{
    protected $fillable = [
        'name',
        'short_name',
        'min_value',
        'max_value',
        'unit'
    ];

    public function informations(){
        return $this->hasMany(Information::class, 'info_type_id');
    }
}
