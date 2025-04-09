<?php

namespace App\Http\Requests\MyCompanyEmployee;

use App\Enums\Common\DisplayOrderEnum;
use App\Enums\Common\UseFlagEnum;
use App\Enums\Negotiation\PositionClassificationEnum;
use App\Http\Requests\TimestampRequest;
use Illuminate\Validation\Rule;

class UpsertMyCompanyEmployeeRequest extends TimestampRequest
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
        $rule = [];
        if ($this->checkStoreRequest()) {
            $rule = ['employee_id' => ['required', 'numeric', Rule::exists('organization_employees', 'id')],];
        }
        return [
            ...parent::rules(),
            ...$rule,
            'position_classification' => ['nullable', Rule::in(PositionClassificationEnum::getValues())],
            'memo' => 'nullable|string',
            'display_order' => ['required', 'numeric', 'min:0', 'max:' . DisplayOrderEnum::DEFAULT],
            'use_classification' => Rule::in(UseFlagEnum::getValues()),
        ];
    }

    public function attributes(): array
    {
        return [
            'employee_id' => __('attributes.employee.id'),
            'position_classification' => __('attributes.my_company_employee.position_classification'),
            'memo' => __('attributes.common.memo'),
            'display_order' => __('attributes.common.display_order'),
            'use_classification' => __('attributes.common.use_classification')
        ];
    }
}
