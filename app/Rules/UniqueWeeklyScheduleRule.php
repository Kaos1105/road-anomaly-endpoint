<?php

namespace App\Rules;

use App\Enums\FAQ\AnswerTypeEnum;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\DB;

class UniqueWeeklyScheduleRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        //
        $weeklySchedules = collect($value);
        $isFailed = $weeklySchedules->contains(function (array $weeklySchedule, int $index) use ($weeklySchedules) {
            return $weeklySchedules->slice($index + 1)->contains(function (array $otherItem) use ($weeklySchedule) {
                return ($weeklySchedule['display_employee_id'] === $otherItem['display_employee_id']
                    && $weeklySchedule['display_weekly_classification'] === $otherItem['display_weekly_classification']);
            });
        });

        if ($isFailed) {
            $fail(__('validation.existed', ['attribute' => __('attributes.weekly_schedule.schedule')]));
        }
    }
}
