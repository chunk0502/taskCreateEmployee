<?php

namespace App\Enums\Employee;

use App\Supports\Enum;

enum RolesEnum: int
{
    use Enum;

    case Admin = 1;
    case Dev   = 2;
    case Other = 3;
}
