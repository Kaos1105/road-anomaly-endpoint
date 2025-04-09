<?php

namespace App\Enums\Negotiation;

use BenSampo\Enum\Enum;

final class ProgressClassificationEnum extends Enum
{
    const NOT_YET = 1;
    const DONE = 2;
    const PENDING = 3;
    const CANCEL = 4;
}
