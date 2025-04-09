<?php

namespace App\Enums\Workflow;

use BenSampo\Enum\Enum;

final class ExecutionOrderEnum extends Enum
{
    const UNPROCESS = 1;
    const ORDERED = 2;
    const NOT_ORDER = 3;
}
