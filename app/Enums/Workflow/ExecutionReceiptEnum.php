<?php

namespace App\Enums\Workflow;

use BenSampo\Enum\Enum;

final class ExecutionReceiptEnum extends Enum
{
    const UNPROCESS = 1;
    const RECEIVED = 2;
    const REJECTED = 3;
    const CANCELLED = 4;
}
