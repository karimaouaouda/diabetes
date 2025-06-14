<?php

namespace App\Traits;

use App\Enums\MedicationTime;
use App\Enums\UserRoles;
use App\Models\DoseInsuline;
use App\Models\PatientProfile;
use App\Models\Treatment;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\HasMany;
use mysql_xdevapi\Exception;

/**
 * @mixin User
 */
trait HasPatientRole
{
    public function isPatient() : bool
    {
        return $this->getAttribute('role') == UserRoles::PATIENT;
    }

    public function treatments() : HasMany
    {
        return $this->hasMany(Treatment::class, 'patient_id');
    }

    public function getHourFor(string $at): int|string
    {

        if( !$this->isPatient() ){
            return 0;
        }

        $profile = $this->patientProfile;

        if( !$profile ){
            throw new Exception('patient must have profile');
        }

        $meals = $profile->meals ? $profile->meals[0] : [];

        if( in_array($at, [MedicationTime::BEFORE_BREAKFAST->value, MedicationTime::MIDDLE_BREAKFAST->value, MedicationTime::AFTER_BREAKFAST->value]) )
        {
            list($hour, $minute) = explode(':', $meals['breakfast']);

            return (int) $hour; // Convert to integer
        }

        if(in_array($at, [MedicationTime::BEFORE_LUNCH->value, MedicationTime::MIDDLE_LUNCH->value, MedicationTime::AFTER_LUNCH->value]))
        {
            list($hour, $minute) = explode(':', $meals['lunch']);

            return (int) $hour; // Convert to integer
        }

        list($hour, $minute) = explode(':', $meals['dinner']);

        return (int) $hour; // Convert to integer

    }

    public function dosesInsuline(){
        return $this->hasMany(DoseInsuline::class);
    }

    public function patientProfile()
    {
        return $this->hasOne(PatientProfile::class, 'patient_id');
    }

}
