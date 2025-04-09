<?php

namespace App\Enums\Common;

use BenSampo\Enum\Enum;

final class FavoriteTypeEnum extends Enum
{
    const COMPANY = 'organization_companies';

    const EMPLOYEE = 'organization_employees';

    const SITE = 'organization_sites';

    const DEPARTMENT = 'organization_departments';

    const DIVISION = 'organization_divisions';
}
