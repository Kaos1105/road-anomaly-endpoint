<?php

namespace App\Enums\Excel\System;

use BenSampo\Enum\Enum;

final class SystemHeadingExcelEnum extends Enum
{
    const CODE_OLD = 'CODE (OLD)';

    const CODE = 'CODE (Required)';

    const NAME = 'Name (Required)';

    const OVERVIEW = 'Overview (Nullable)';

    const START_DATE = 'Start date (Required)';

    const END_DATE = 'End date (Nullable)';

    const DEFAULT_PERMISSION_2 = 'Default permission 2 (Required, [1, 2, 3])';

    const DEFAULT_PERMISSION_3 = 'Default permission 3 (Required, [1, 2])';

    const DEFAULT_PERMISSION_4 = 'Default permission 4 (Required, [1, 2, 3, 4])';

    const MEMO = 'Memo (Nullable)';

    const DISPLAY_ORDER = 'Display order (Required, [0 ~ 99999])';

    const USE_CLASSIFICATION = 'Use classification (Required, [1, 2])';

}
