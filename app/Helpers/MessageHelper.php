<?php

namespace App\Helpers;

use App\Enums\Common\PreviousNameFlagEnum;
use App\Models\Employee;

class MessageHelper
{
    public static function getEmployeeName(Employee $employee): string|null
    {
        if ($employee->maiden_name && $employee->previous_name_flg == PreviousNameFlagEnum::COMBINED) {
            return "{$employee->code} {$employee->last_name}　{$employee->first_name}（旧 {$employee->maiden_name}）";
        }

        return "{$employee->code} {$employee->last_name}　{$employee->first_name}";
    }
}
