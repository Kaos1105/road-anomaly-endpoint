<?php

namespace App\Enums\Common;

use BenSampo\Enum\Enum;

final class PaginationEnum extends Enum
{
    const PER_PAGE = 25;

    const CURSOR_PER_PAGE = 50;

    const FIRST_PAGE = 1;

    const NUMBER_RECORD_DASHBOARD = 3;

    const NUMBER_RECORD_DASHBOARD_5 = 5;

    const NUMBER_RECORD_DASHBOARD_10 = 10;

    const PER_PAGE_1000 = 1000;

    const PER_PAGE_100 = 100;
}
