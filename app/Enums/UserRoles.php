<?php

namespace App\Enums;

enum UserRoles : string
{
    case DOCTOR = 'doctor';

    case ADMIN = 'admin';

    case PATIENT = 'patient';
}
