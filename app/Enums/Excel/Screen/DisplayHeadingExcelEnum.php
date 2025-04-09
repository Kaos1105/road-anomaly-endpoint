<?php

namespace App\Enums\Excel\Screen;

use BenSampo\Enum\Enum;

final class DisplayHeadingExcelEnum extends Enum
{
    const SYSTEM_CODE = 'System CODE';

    const CODE_OLD = 'CODE (OLD)';

    const CODE = 'CODE (Required)';

    const DISPLAY_CLASSIFICATION = 'Screen classification (Required, [1, 2, 3, 4, 5, 6])';

    const NAME = 'Name (Required)';

    const MEMO = 'Memo (Nullable)';

    const DISPLAY_ORDER = 'Display order (Required, [0 ~ 99999])';

    const USE_CLASSIFICATION = 'Use classification (Required, [1, 2])';

}
