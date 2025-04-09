<?php

namespace App\Enums\Department;

use BenSampo\Enum\Enum;

final class DepartmentClassificationEnum extends Enum
{
    const GENERAL_AFFAIRS = 1;

    const ACCOUNTING = 11;

    const CORPORATE_PLANNING = 21;

    const INFORMATION_TECHNOLOGY = 31;

    const SALES = 41;

    const MANUFACTURING = 51;

    const QUALITY_ASSURANCE = 61;

    const PURCHASE = 71;

    const LOGISTICS = 72;

    const OTHER = 99;
}
