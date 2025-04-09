<?php

namespace App\Http\Requests\Department;

use App\Enums\Common\DisplayOrderEnum;
use App\Enums\Common\PreviousNameFlagEnum;
use App\Enums\Common\RepresentFlagEnum;
use App\Enums\Common\UseFlagEnum;
use App\Enums\Department\DepartmentClassificationEnum;
use App\Http\Requests\TimestampRequest;
use App\Models\Department;
use Illuminate\Validation\Rule;

class UpsertDepartmentRequest extends TimestampRequest
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
        /**
         * @var Department $department
         */
        $startDateRule = ['nullable', 'date', 'max:10'];
        $endDateRule = ['nullable', 'date', 'max:10'];
        if ($this->request->get('start_date') && $this->request->get('end_date')) {
            $startDateRule = [...$startDateRule, 'before_or_equal:end_date'];
            $endDateRule = [...$endDateRule, 'after_or_equal:start_date'];
        }
        return [
            ...parent::rules(),
            'code' => 'nullable|string|max:20',
            'site_id' => ['required', 'numeric', Rule::exists('organization_sites', 'id')],
            'long_name' => 'required|string|min:1|max:100',
            'short_name' => 'nullable|string|max:100',
            'kana' => 'nullable|string|max:100',
            'start_date' => $startDateRule,
            'end_date' => $endDateRule,
            'represent_flg' => Rule::in(RepresentFlagEnum::getValues()),
            'department_classification' => Rule::in(DepartmentClassificationEnum::getValues()),
            'previous_name' => 'nullable|string|max:100',
            'previous_name_flg' => ['required', Rule::in(PreviousNameFlagEnum::getValues())],
            'en_notation' => 'nullable|string|max:100',
            'phone' => 'nullable|string|max:20',
            'memo' => 'nullable|string',
            'display_order' => ['required', 'numeric', 'min:0', 'max:' . DisplayOrderEnum::DEFAULT],
            'use_classification' => Rule::in(UseFlagEnum::getValues()),
        ];
    }

    public function attributes(): array
    {
        return [
            'code' => __('attributes.department.code'),
            'site_id' => __('attributes.department.site_id'),
            'long_name' => __('attributes.department.long_name'),
            'short_name' => __('attributes.department.short_name'),
            'kana' => __('attributes.department.kana'),
            'start_date' => __('attributes.department.start_date'),
            'end_date' => __('attributes.department.end_date'),
            'represent_flg' => __('attributes.department.represent_flg'),
            'department_classification' => __('attributes.department.department_classification'),
            'previous_name' => __('attributes.department.previous_name'),
            'previous_name_flg' => __('attributes.department.previous_name_flg'),
            'en_notation' => __('attributes.department.en_notation'),
            'phone' => __('attributes.department.phone'),
            'memo' => __('attributes.department.memo'),
            'display_order' => __('attributes.common.display_order'),
            'use_classification' => __('attributes.common.use_classification')
        ];
    }
}
