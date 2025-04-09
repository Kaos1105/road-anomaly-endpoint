<?php

namespace App\Enums\Employee;

use BenSampo\Enum\Enum;

final class EmployeeClassificationEnum extends Enum
{
    const EMPLOYEE = 1;

    const CUSTOMER = 2;

    const TEACHER = 3;

    const OTHER = 99;

}
