<?php

namespace App\Http\Requests\WeeklySchedule;

use App\Models\WeeklySchedule;
use App\Rules\UniqueDragNDropWeeklyRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DragNDropScheduleRequest extends FormRequest
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
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $weeklyScheduleIds = WeeklySchedule::query()->pluck('id');

        return [
            'schedule_start' => ['required'],
            'schedule_end' => ['required'],
            'schedule_start.display_order' => ['required', 'numeric'],
            'schedule_start.id' => ['required', 'numeric', Rule::in($weeklyScheduleIds), new UniqueDragNDropWeeklyRule()],
            'schedule_end.display_order' => ['required', 'numeric'],
            'schedule_end.id' => ['required', 'numeric', Rule::in($weeklyScheduleIds)],
        ];
    }

    public function attributes(): array
    {
        return [
        ];
    }
}
