<?php

namespace App\Helpers;

use App\Models\Display;
use App\Models\System;

class SystemHelper
{
    public static function getSystemName(string $systemCode): string|null
    {
        $system = System::where('code', $systemCode)->first();
        return $system?->name;
    }

    public static function getSystemId(string $systemCode): int|null
    {
        $system = System::where('code', $systemCode)->first();

        return $system?->id;
    }

}
