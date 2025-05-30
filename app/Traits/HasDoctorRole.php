<?php

namespace App\Traits;

use App\Enums\UserRoles;
use App\Models\User;

/**
 * @mixin User
*/
trait HasDoctorRole
{
    public function isDoctor() : bool
    {
        return $this->getAttribute('role') == UserRoles::DOCTOR;
    }
}
