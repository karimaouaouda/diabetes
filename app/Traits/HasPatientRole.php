<?php

namespace App\Traits;

use App\Enums\UserRoles;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
        //
    }


}
