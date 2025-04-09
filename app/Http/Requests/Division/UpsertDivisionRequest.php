<?php

namespace App\Http\Requests\Division;

use App\Enums\Common\DisplayOrderEnum;
use App\Enums\Common\PreviousNameFlagEnum;
use App\Enums\Common\UseFlagEnum;
use App\Enums\Division\DivisionClassificationEnum;
use App\Http\Requests\TimestampRequest;
use Illuminate\Validation\Rule;

class UpsertDivisionRequest extends TimestampRequest
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
        $departmentIdRule = [];
        $startDateRule = ['nullable', 'date', 'max:10'];
        $endDateRule = ['nullable', 'date', 'max:10'];
        if ($this->request->get('start_date') && $this->request->get('end_date')) {
            $startDateRule = [...$startDateRule, 'before_or_equal:end_date'];
            $endDateRule = [...$endDateRule, 'after_or_equal:start_date'];
        }
        if ($this->checkStoreRequest()) {
            $departmentIdRule = ['department_id' => ['required', 'numeric', Rule::exists('organization_departments', 'id')]];
        }
        return [
            ...parent::rules(),
            ...$departmentIdRule,
            'code' => 'nullable|string|min:1|max:20',
            'long_name' => 'required|string|min:1|max:100',
            'short_name' => 'nullable|string|max:100',
            'kana' => 'nullable|string|max:100',
            'start_date' => $startDateRule,
            'end_date' => $endDateRule,
            'division_classification' => Rule::in(DivisionClassificationEnum::getValues()),
            'previous_name' => 'nullable|string|max:100|min:1',
            'previous_name_flg' => ['required', Rule::in(PreviousNameFlagEnum::getValues())],
            'en_notation' => 'nullable|string|max:100',
            'phone' => 'nullable|string|max:20|min:1',
            'memo' => 'nullable|string',
            'display_order' => ['required', 'numeric', 'min:0', 'max:' . DisplayOrderEnum::DEFAULT],
            'use_classification' => Rule::in(UseFlagEnum::getValues()),
        ];
    }

    public function attributes(): array
    {
        return [
            'code' => __('attributes.division.code'),
            'department_id' => __('attributes.division.department_id'),
            'long_name' => __('attributes.division.long_name'),
            'short_name' => __('attributes.division.short_name'),
            'kana' => __('attributes.division.kana'),
            'start_date' => __('attributes.division.start_date'),
            'end_date' => __('attributes.division.end_date'),
            'division_classification' => __('attributes.division.division_classification'),
            'previous_name' => __('attributes.division.previous_name'),
            'previous_name_flg' => __('attributes.division.previous_name_flg'),
            'en_notation' => __('attributes.division.en_notation'),
            'phone' => __('attributes.division.phone'),
            'memo' => __('attributes.division.memo'),
            'display_order' => __('attributes.common.display_order'),
            'use_classification' => __('attributes.common.use_classification')
        ];
    }
}

