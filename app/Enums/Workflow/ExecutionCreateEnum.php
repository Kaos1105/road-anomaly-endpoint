<?php

namespace App\Enums\Workflow;

use BenSampo\Enum\Enum;

final class ExecutionCreateEnum extends Enum
{
    const UNPROCESS = 1;
    const PREPARATION_COMPLETED = 2;
}
