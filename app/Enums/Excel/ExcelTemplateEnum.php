<?php

namespace App\Enums\Excel;

use BenSampo\Enum\Enum;

final class ExcelTemplateEnum extends Enum
{
    const ROW_HEADING = 1;

    const ROW_RECORD_START = 2;

    const COLUMN_START = 'A';

    const FIRST_SHEET = 0;

    const CSV_TYPE = 'csv';
    const TEXT_FILE = 'txt';

}
