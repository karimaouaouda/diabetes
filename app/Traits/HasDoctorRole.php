<?php

namespace App\Traits;

use App\Enums\UserRoles;
use App\Models\InsulinSettings;
use App\Models\Medication;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @mixin User
*/
trait HasDoctorRole
{
    public function isDoctor() : bool
    {
        return $this->getAttribute('role') == UserRoles::DOCTOR;
    }
    public function patients(){
        return $this->belongsToMany(User::class, 'followings', 'doctor_id', 'patient_id')
            ->where('status', 'accepted');
    }

    public function medications(): HasMany
    {
        return $this->hasMany(Medication::class, 'doctor_id');
    }

    public function insulineSettings(): HasMany
    {
        if( $this->isDoctor() ){
            return $this->hasMany(InsulinSettings::class, 'doctor_id');
        }else{
            return $this->hasMany(InsulinSettings::class, 'patient_id');
        }
    }
}
