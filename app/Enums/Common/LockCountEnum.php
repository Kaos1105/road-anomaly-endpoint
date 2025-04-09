<?php

namespace App\Enums\Common;

use BenSampo\Enum\Enum;

final class LockCountEnum extends Enum
{
    const MAX_ATTEMPT_COUNT = 5;

    const DECAY_RATE_MINUTE = 15;
}
