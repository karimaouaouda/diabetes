<?php

namespace App\Models;

use App\Enums\InformationOrder;
use Illuminate\Database\Eloquent\Model;

class Information extends Model
{
    protected $fillable = [
        'patient_id',
        'info_type_id',
        'info_order',
        'value'
    ];


    protected $casts = [
        'info_order' => InformationOrder::class
    ];


    public function patient(){
        return $this->belongsTo(User::class, 'patient_id');
    }

    public function informationType(){
        return $this->belongsTo(InformationType::class, 'info_type_id');
    }


}
