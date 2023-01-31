<?php

declare(strict_types=1);

namespace App\Enums;

enum UserTypes: string
{
    case DOCTOR = 'DOCTOR';
    case PATIENT = 'PATIENT';
}
