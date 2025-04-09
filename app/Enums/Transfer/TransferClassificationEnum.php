<?php

namespace App\Enums\Transfer;

use BenSampo\Enum\Enum;

final class TransferClassificationEnum extends Enum
{
    const JOINING_COMPANY = 1;

    const PROMOTION = 2;

    const TRANSFER = 3;

    const REASSIGNMENT = 4;

    const RETIREMENT = 5;

    const OTHER = 99;

}
