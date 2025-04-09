<?php

namespace App\Enums\Schedule;

use BenSampo\Enum\Enum;

final class WeeklyEnum extends Enum
{
    const LAST_WEEK = -1;

    const THIS_WEEK = 0;

    const NEXT_WEEK = 1;

    const TWO_WEEK_FROM_NOW = 2;

    const THREE_WEEK_FROM_NOW = 3;

}
