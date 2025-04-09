<?php

namespace App\Http\Requests\Group;

use App\Enums\Common\DisplayOrderEnum;
use App\Enums\Common\UseFlagEnum;
use App\Http\Requests\TimestampRequest;
use App\Models\Group;

use Illuminate\Validation\Rule;

class UpsertGroupRequest extends TimestampRequest
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
         * @var $group Group
         */
        $group = request('group');
        $employeeIdsRule = [];
        if (!$group) {
            $employeeIdsRule = [
                'employee_ids' => 'array|min:1|distinct',
                'employee_ids.*' => ['required', 'numeric', Rule::exists('organization_employees', 'id')]
            ];
        }
        return [
            ...parent::rules(),
            ...$employeeIdsRule,
            'name' => ['required', 'string', 'max:100', Rule::unique('main_groups', 'name')->ignore($group?->id)],
            'display_order' => ['required', 'numeric', 'min:0', 'max:' . DisplayOrderEnum::DEFAULT],
            'use_classification' => Rule::in(UseFlagEnum::getValues()),
        ];

    }

    public function attributes(): array
    {
        return [
            'name' => __('attributes.group.name'),
            'display_order' => __('attributes.common.display_order'),
            'use_classification' => __('attributes.common.use_classification'),
            'employee_ids' => __('attributes.group.employee_ids'),
            'employee_ids.*' => __('attributes.group.employee_ids'),
        ];
    }
}
