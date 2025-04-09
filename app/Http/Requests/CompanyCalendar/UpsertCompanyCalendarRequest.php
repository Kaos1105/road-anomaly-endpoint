<?php

namespace App\Http\Requests\CompanyCalendar;

use App\Enums\Schedule\CalendarClassificationEnum;
use App\Enums\Schedule\WorkClassificationEnum;
use App\Http\Requests\TimestampRequest;

use App\Models\CompanyCalendar;
use Illuminate\Validation\Rule;


class UpsertCompanyCalendarRequest extends TimestampRequest
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
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */

    /**
     * @mixin CompanyCalendar
     */

    public function rules(): array
    {
        return [
            'company_calendar' => ['array', 'min:1'],
            'company_calendar.*.date' => [
                'date',
                'required',
                'max:10'
            ],
            'company_calendar.*.calendar_classification' => [
                'numeric',
                'required',
                Rule::in(CalendarClassificationEnum::getValues())
            ],
            'company_calendar.*.calendar_contents' => 'string|nullable|max:20',
            'company_calendar.*.work_classification' => [
                'numeric',
                'required',
                Rule::in(WorkClassificationEnum::getValues())
            ],
        ];
    }

    public function attributes(): array
    {
        return [
            'company_calendar.*.date' => __('attributes.company_calendar.date'),
            'company_calendar.*.calendar_classification' => __('attributes.company_calendar.calendar_classification'),
            'company_calendar.*.calendar_contents' => __('attributes.company_calendar.calendar_content'),
            'company_calendar.*.work_classification' => __('attributes.company_calendar.work_classification'),
        ];
    }

    public function after(): array
    {
        return [
            function ($validator) {
                $data = $this->input('company_calendar');
                $dates = [];
                foreach ($data as $index => $item) {
                    $date = $item['date'];
                    if (in_array($date, $dates)) {
                        $validator->errors()->add("company_calendar.$index.date", trans('validation.unique', ['attribute' => __('attributes.company_calendar.date')]));
                    }
                    $dates[] = $date;
                }
            }
        ];
    }

}
