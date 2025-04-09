<?php

namespace App\Http\Requests\ManagementDepartment;

use App\Enums\Common\DisplayOrderEnum;
use App\Enums\Common\UseFlagEnum;
use App\Http\Requests\TimestampRequest;
use App\Models\ManagementDepartment;
use Illuminate\Validation\Rule;

class UpsertManagementDepartmentRequest extends TimestampRequest
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
         * @var ManagementDepartment $managementDepartment
         */
        $managementDepartment = request('management_department');
        $rule = [];
        $rule['name'] = ['required', 'string', 'max:100'];
        $rule['department_id'] = ['required', Rule::exists('organization_departments', 'id')];

        if (!$managementDepartment) {
            $rule['name'][] = Rule::unique('negotiation_management_departments', 'name');
        } else {
            $rule['department_id'] = ['nullable'];
            $rule['name'][] = Rule::unique('negotiation_management_departments', 'name')->ignore($managementDepartment->id);
        }

        return [
            ...parent::rules(),
            ...$rule,
            'memo' => 'nullable|string',
            'display_order' => ['required', 'numeric', 'min:0', 'max:' . DisplayOrderEnum::DEFAULT],
            'use_classification' => Rule::in(UseFlagEnum::getValues()),
        ];
    }

    public function attributes(): array
    {
        return [
            'department_id' => __('attributes.department.id'),
            'name' => __('attributes.management_department.name'),
            'memo' => __('attributes.common.memo'),
            'display_order' => __('attributes.common.display_order'),
            'use_classification' => __('attributes.common.use_classification')
        ];
    }
}
