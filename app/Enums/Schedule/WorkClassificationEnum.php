<?php

namespace App\Enums\Schedule;

use BenSampo\Enum\Enum;

final class WorkClassificationEnum extends Enum
{
    const WORK_DAY = 1;

    const DAY_OFF = 2;

    const ABSENCE = 3;

    const PAID_LEAVE = 4;

    const PAID_LEAVE_AM = 5;

    const PAID_LEAVE_PM = 6;

    const ABSENCE_AM = 7;

    const ABSENCE_PM = 8;

    const SHIFTED_HOLIDAY = 9;

    const COMPENSATORY_HOLIDAY = 10;

    const SPECIAL_LEAVE = 11;

    const LEAVE_OF_ABSENCE_EMPLOYED = 12;

    const SICK_LEAVE = 13;

    const OTHER = 14;
}
