<?php

namespace App\Enums\Chat;

use BenSampo\Enum\Enum;

final class ChatClassification extends Enum
{
    const USER_CONTENT = 1;
    const ADMIN_CONTENT = 2;
}
