<?php

namespace App\Enums\Schedule;

use BenSampo\Enum\Enum;

final class CalendarClassificationEnum extends Enum
{
    const WEEKDAY = 1;

    const SUNDAY_HOLIDAY = 2;

    const NATIONAL_HOLIDAY = 3;

    const SATURDAY_HOLIDAY = 4;

    const SPECIFIC_HOLIDAY = 5;

    const SUBSTITUTE_HOLIDAY = 6;

}
