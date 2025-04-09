<?php

namespace App\Enums\Transfer;

use BenSampo\Enum\Enum;

final class ContractClassificationEnum extends Enum
{
    const NO_CONTRACT = 1;

    const INDEFINITE = 2;

    const DEFINITE = 3;

    const COMMISSIONED = 4;
}
