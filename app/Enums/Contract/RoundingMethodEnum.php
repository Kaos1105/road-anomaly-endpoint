<?php

namespace App\Enums\Contract;

use BenSampo\Enum\Enum;

final class RoundingMethodEnum extends Enum
{
    const HALF_UP = 1;

    const DOWN = 2;

    const UP = 3;
}
