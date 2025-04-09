<?php

namespace App\Http\Requests\Schedule;

use App\Enums\Common\DateTimeEnum;
use App\Enums\Schedule\PublicClassificationEnum;
use App\Models\Login;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpsertTimeScheduleRequest extends FormRequest
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
        /** @var Login $login */
        $login = \Auth::user();

        $this->merge([
            'updated_at' => Carbon::now()->format(DateTimeEnum::DATE_TIME_FORMAT_V2),
            'updated_by' => $login->employee_id,
        ]);

        if ($this->input('public_classification') !== PublicClassificationEnum::PUBLIC_GROUP) {
            $this->merge(['public_group_id' => null]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $timeRules = ['bail', 'nullable', 'date_format:H:i'];
        $timeRule = [
            'start_time' => [...$timeRules, $this->input('end_time') ? 'before_or_equal:end_time' : null],
            'end_time' => [...$timeRules, $this->input('start_time') ? 'after_or_equal:start_time' : null]
        ];

        $publicGroup = ($this->input('public_classification') === PublicClassificationEnum::PUBLIC_GROUP)
            ? ['required', 'numeric', Rule::exists('main_groups', 'id')]
            : ['nullable'];

        return [
            'id' => ['nullable', 'numeric', Rule::exists('schedule_time_schedule', 'id')],
            'employee_id' => ['required_if:id,null', 'numeric', Rule::exists('organization_employees', 'id')],
            'date' => 'required|date',
            ...$timeRule,
            'work_contents' => 'nullable|string|max:100',
            'work_place' => 'nullable|string|max:100',
            'updated_at' => ['string', 'nullable'],
            'updated_by' => ['numeric', 'nullable'],
            'public_classification' => ['required', 'numeric', Rule::in(PublicClassificationEnum::getValues())],
            'public_group_id' => $publicGroup,
        ];
    }

    public function attributes(): array
    {
        return [
            'employee_id' => __('attributes.time_schedule.employee_id'),
            'date' => __('attributes.time_schedule.date'),
            'start_time' => __('attributes.time_schedule.start_time'),
            'end_time' => __('attributes.time_schedule.end_time'),
            'work_contents' => __('attributes.time_schedule.work_contents'),
            'work_place' => __('attributes.time_schedule.work_place'),
            'public_classification' => __('attributes.time_schedule.public_classification'),
            'public_group_id' => __('attributes.time_schedule.public_group_id'),
        ];
    }

    public function messages(): array
    {
        return [
            'start_time.before_or_equal' => __('validation.time.before_or_equal', [
                'attribute' => __('attributes.time_schedule.start_time'),
                'time' => __('attributes.time_schedule.end_time'),
            ]),
            'end_time.after_or_equal' => __('validation.time.after_or_equal', [
                'attribute' => __('attributes.time_schedule.end_time'),
                'time' => __('attributes.time_schedule.start_time'),
            ]),
        ];
    }
}
