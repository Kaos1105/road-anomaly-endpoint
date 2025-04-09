<?php

namespace App\Enums\AccessPermission;

use BenSampo\Enum\Enum;

final class Permission1FlagEnum extends Enum
{
    const UN_AUTHORIZED_USER = 1;
    const SYSTEM_USER = 2;
    const SYSTEM_MANAGER = 3;
}
