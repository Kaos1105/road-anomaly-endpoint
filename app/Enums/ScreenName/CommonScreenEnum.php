<?php

namespace App\Enums\ScreenName;

use BenSampo\Enum\Enum;

final class CommonScreenEnum extends Enum
{
    const SYSTEM_PERMISSION_LIST = "6A000";
    const SYSTEM_PERMISSION_EDIT = "6A100";

    const ANNOUNCEMENT_LIST = "6B000";
    const ANNOUNCEMENT_SHOW = "6B010";
    const ANNOUNCEMENT_CREATE = "6B020";
    const ANNOUNCEMENT_COPY = "6B021";
    const ANNOUNCEMENT_EDIT = "6B030";
}
