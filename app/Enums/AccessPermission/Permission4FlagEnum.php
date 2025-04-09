<?php

namespace App\Enums\AccessPermission;

use BenSampo\Enum\Enum;

final class Permission4FlagEnum extends Enum
{
    const AFFILIATED_DIVISION = 1;
    const AFFILIATED_DEPARTMENT = 2;
    const AFFILIATED_SITE = 3;
    const ENTIRE_COMPANY = 4;
}
