<?php

namespace App\Enums\Contract;

use BenSampo\Enum\Enum;

final class ContractStatusEnum extends Enum
{
    const BEFORE_CONTRACT_START = 1;

    const DURING_CONTRACT = 2;

    const END_CONTRACT = 3;

    const UNREGISTERED_CONTRACT_PERIOD = 4;
}
