<?php

namespace App\Helpers;

use App\Enums\Schedule\WeeklyDateEnum;
use App\Models\Employee;
use BenSampo\Enum\Exceptions\InvalidEnumKeyException;

class DisplayHelper
{
    public static function formatEmployeeName(Employee|null $employee): ?string
    {
        if ($employee) {
            return $employee->last_name . '　' . $employee->first_name;
        }

        return null;
    }

    /**
     * @throws InvalidEnumKeyException
     */
    public static function getNameFromDayOfWeek(int $day): ?string
    {
        if ($day) {
            return WeeklyDateEnum::fromKey("DAY_$day")->value;
        }
        return null;
    }
}
