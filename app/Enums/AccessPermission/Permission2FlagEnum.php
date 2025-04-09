<?php

namespace App\Enums\AccessPermission;

use BenSampo\Enum\Enum;

final class Permission2FlagEnum extends Enum
{
    const DATA_VIEWING = 1;
    const TRANSACTION_EDIT = 2;
    const MASTER_EDIT = 3;
}
