<?php

namespace App\Http\Requests\Schedule;

use App\Enums\Schedule\WorkClassificationEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpsertDailyScheduleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {

        return [
            'employee_id' => ['required', 'numeric', Rule::exists('organization_employees', 'id')],
            'date' => 'required|date_format:Y-m-d',
            'work_classification' => ['required', Rule::in(WorkClassificationEnum::getValues())],
        ];
    }

    public function attributes(): array
    {
        return [
            'employee_id' => __('attributes.daily_schedule.employee_id'),
            'date' => __('attributes.daily_schedule.date'),
            'work_classification' => __('attributes.daily_schedule.work_classification'),

        ];
    }
}
