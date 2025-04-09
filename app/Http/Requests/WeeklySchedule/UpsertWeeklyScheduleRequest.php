<?php

namespace App\Http\Requests\WeeklySchedule;

use App\Enums\AccessHistory\AccessActionTypeEnum;
use App\Enums\AccessHistory\AccessibleTypeEnum;
use App\Enums\Schedule\DisplayWeeklyClassificationEnum;
use App\Models\Employee;
use App\Models\System;
use App\Rules\UniqueWeeklyScheduleRule;
use Auth;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpsertWeeklyScheduleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $weeklySchedules = collect(request()->input('weekly_schedules', []));

        $userId = Auth::user()->employee_id;

        // Add user_id and display_order to each schedule
        $weeklySchedules = $weeklySchedules->map(function (array $weeklySchedule, int $index) use ($userId) {
            $weeklySchedule['user_id'] = $userId;
            $weeklySchedule['display_order'] = $index + 1;
            return $weeklySchedule;
        });

        $this->merge([
            'weekly_schedules' => $weeklySchedules->toArray(),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'weekly_schedules' => ['required', 'array', new UniqueWeeklyScheduleRule()],
            'weekly_schedules.*.display_employee_id' => ['required', 'numeric', Rule::in(Employee::query()->pluck('id'))],
            'weekly_schedules.*.display_weekly_classification' => ['required', 'numeric', Rule::in(DisplayWeeklyClassificationEnum::getValues())],
            'weekly_schedules.*.user_id' => ['nullable', 'numeric'],
            'weekly_schedules.*.display_order' => ['nullable', 'numeric'],
        ];
    }

    public function attributes(): array
    {
        return [
            'weekly_schedules' => __('attributes.weekly_schedule.schedule'),
            'weekly_schedules.*.display_weekly_classification' => __('attributes.weekly_schedule.display_weekly_classification'),
            'weekly_schedules.*.display_employee_id' => __('attributes.weekly_schedule.display_weekly_classification'),
        ];
    }
}
