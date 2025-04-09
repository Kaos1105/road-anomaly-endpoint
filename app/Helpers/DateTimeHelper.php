<?php

namespace App\Helpers;

use App\Enums\Common\DateTimeEnum;
use Carbon\Carbon;

class DateTimeHelper
{
    public static function formatDateTime(?string $datetime, string $format): ?string
    {
        if ($datetime) {
            return Carbon::parse($datetime)->format($format);
        }

        return null;
    }


    public static function changeDateFormat(string $dateString): array|string
    {
        return str_replace('/', '-', $dateString);
    }

    public static function formatHourToString(string|int $hour): string
    {
        return $hour ? sprintf(DateTimeEnum::HOUR_TITLE_FORMAT, round($hour)) : '00';
    }

    public static function formatDateSystem(?string $date): ?string
    {
        if (!$date) {
            return null;
        }

        $formats = [
            DateTimeEnum::DATE_FORMAT,
            DateTimeEnum::DATE_FORMAT_DMY,
            DateTimeEnum::DATE_FORMAT_MDY,
        ];

        foreach ($formats as $format) {
            try {
                return Carbon::createFromFormat($format, $date)->format(DateTimeEnum::DATE_TIME_FORMAT_V2);
            } catch (\Exception $exception) {
                // Continue to check the remaining format
            }
        }
        return null;
    }
}
