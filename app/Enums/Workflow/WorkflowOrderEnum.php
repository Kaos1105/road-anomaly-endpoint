<?php

namespace App\Enums\Workflow;

use BenSampo\Enum\Enum;

final class WorkflowOrderEnum extends Enum
{
    const CREATE = 0;
    const PREPARE = 10;
    const DRAFTING = 20;
    const APPLY = 30;
    const APPROVED = 40;
    const DECISION = 50;
    const ORDER = 60;
    const RECEIPT = 70;
    const PAYMENT = 80;
    const FINISH = 90;
}
