<?php

namespace App\Enums\Schedule;

use BenSampo\Enum\Enum;

final class DisplayWeeklyClassificationEnum extends Enum
{
    const LAST_WEEK = 1;

    const THIS_WEEK = 2;

    const NEXT_WEEK = 3;

    const TWO_WEEK_FROM_THIS_WEEK = 4;

    const THREE_WEEK_FROM_THIS_WEEK = 5;

}
