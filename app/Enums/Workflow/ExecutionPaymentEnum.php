<?php

namespace App\Enums\Workflow;

use BenSampo\Enum\Enum;

final class ExecutionPaymentEnum extends Enum
{
    const UNPROCESS = 1;
    const PAID = 2;
    const NOT_PAID = 3;
}
