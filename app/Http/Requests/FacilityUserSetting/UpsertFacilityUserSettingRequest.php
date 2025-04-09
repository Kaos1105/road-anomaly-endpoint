<?php

namespace App\Http\Requests\FacilityUserSetting;

use App\Enums\Facility\HolidayDisplayEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpsertFacilityUserSettingRequest extends FormRequest
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
    public function rules(): array
    {
        return [
            'facility_group_id' => ['required', 'numeric', Rule::exists('facility_facility_groups', 'id')],
            'holiday_display' => ['required', 'numeric', Rule::in(HolidayDisplayEnum::getValues())],
        ];

    }

    public function attributes(): array
    {
        return [
            'facility_group_id' => __('attributes.facility.facility_group_id'),
            'holiday_display' => __('attributes.facility_user_setting.holiday_display'),
        ];
    }
}
