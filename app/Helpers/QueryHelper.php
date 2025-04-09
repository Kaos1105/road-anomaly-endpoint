<?php

namespace App\Helpers;

use App\Models\Employee;

class QueryHelper
{
    public static function getEmployeeName(int $employeeId): string
    {
        $employeeId = Employee::whereId($employeeId)->first();

        return $employeeId ? $employeeId->name : '';
    }
}
