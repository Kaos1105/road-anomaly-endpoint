<?php

namespace App\Enums\Common;

use BenSampo\Enum\Enum;

final class DateTimeEnum extends Enum
{
    const DATE_TIME_FORMAT = 'Y/m/d H:i:s';

    const FILE_TITLE_FORMAT = 'Y.m.d H:i:s';

    const DATE_TIME_FORMAT_WO_SECOND = 'Y/m/d H:i';

    const DATE_TIME_FORMAT_WO_THIRD = 'm/d H:i';

    const DATE_TIME_FORMAT_V1 = 'Y-m-d H:i';

    const DATE_TIME_FORMAT_V2 = 'Y-m-d H:i:s';

    const DATE_FORMAT = 'Y/m/d';

    const DATE_FORMAT_DMY = 'd/m/Y';

    const DATE_FORMAT_MDY = 'm/d/Y';

    const DATE_FORMAT_V2 = 'Y-m-d';

    const DATE_FORMAT_V3 = 'Ymd';

    const TIME_FORMAT = 'Hi';

    const TIME_FORMAT_V2 = 'H:i';

    const YEAR_MONTH_DB_FORMAT = '%Y-%m';

    const YEAR_MONTH_PHP_FORMAT = 'Y-m';

    const YEAR_FORMAT = 'Y';
    const YEAR_MONTH_FORMAT = 'Y/m';

    const MONTH_FORMAT = 'm';

    const MONTH_NUMBER_FORMAT = 'n';

    const HOUR_MINUTE_FORMAT = 'H:i';

    const MONTH_NAME_FORMAT = 'F';

    const MONTHS_OF_YEAR = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12];

    const SHORT_NAME_MONTHS_OF_YEAR = ['jan', 'feb', 'mar', 'apr', 'may', 'jun', 'jul', 'aug', 'sep', 'oct', 'nov', 'dec'];

    const TOKYO_TIMEZONE = 'Asia/Tokyo';

    const HOUR_TITLE_FORMAT = '%02d';
}
