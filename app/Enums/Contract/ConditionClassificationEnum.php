<?php

namespace App\Enums\Contract;

use BenSampo\Enum\Enum;

final class ConditionClassificationEnum extends Enum
{
    const PURPOSE = 100;
    const PAYMENT_TERMS = 200;
    const CONTRACT_DURATION = 300;
    const DELIVERY_TERMS = 400;
    const COMPENSATION = 500;
    const CONFIDENTIALITY = 600;
    const INTELLECTUAL = 700;
    const LIABILITY = 800;
    const DISCLAIMER = 900;
    const CONTRACT_TERMINATION = 1000;
    const FORCE_MAJEURE = 1100;
    const PENALTY = 1200;
    const GOVERNING_LAW = 1300;
    const EXCLUSION = 1400;
    const OTHER = 9000;

}
