<?php

namespace App\Enums\Excel\Content;

use BenSampo\Enum\Enum;

final class ContentHeadingExcelEnum extends Enum
{
    const SCREEN_CODE = 'Screen CODE';

    const NO_OLD = 'NO (OLD)';

    const NO = 'NO (NEW/Required)';

    const CONTENT_CLASSIFICATION = 'Content classification (Required, [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11])';

    const NAME = 'Name (Required)';

    const PERMISSION_1 = 'Permission 1 (Required, [1, 2, 3])';

    const PERMISSION_2 = 'Permission 2 (Required, [1, 2, 3])';

    const PERMISSION_3 = 'Permission 3 (Required, [1, 2])';

    const PERMISSION_4 = 'Permission 4 (Required, [1, 2, 3, 4])';

    const MEMO = 'Memo (Nullable)';

    const DISPLAY_ORDER = 'Display order (Required, [0 ~ 99999])';

    const USE_CLASSIFICATION = 'Use classification (Required, [1, 2])';

}
