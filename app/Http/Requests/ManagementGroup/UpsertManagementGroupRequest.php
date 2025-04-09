<?php

namespace App\Http\Requests\ManagementGroup;

use App\Enums\Common\DisplayOrderEnum;
use App\Enums\Common\UseFlagEnum;
use App\Http\Requests\TimestampRequest;
use App\Models\ManagementGroup;
use Illuminate\Validation\Rule;

class UpsertManagementGroupRequest extends TimestampRequest
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
         * @var $managementGroup ManagementGroup
         */
        $managementGroup = request('management_group');
        return [
            ...parent::rules(),
            'name' => [
                'required', 'string', 'min:1', 'max:100', Rule::unique('social_management_groups', 'name')->ignore($managementGroup?->id)
            ],
            'sender_post_code' => 'nullable|string|max:20',
            'sender_address_1' => 'nullable|string|max:100',
            'sender_address_2' => 'nullable|string|max:100',
            'sender_address_3' => 'nullable|string|max:100',
            'sender_name' => 'nullable|string|max:100',
            'contact_point' => 'nullable|string|max:100',
            'contact_phone' => 'nullable|string|max:20',
            'preparatory_personnel_id' => 'required|numeric',
            'applicant_id' => 'required|numeric',
            'approver_id' => 'required|numeric',
            'final_decision_maker_id' => 'required|numeric',
            'ordering_personnel_id' => 'required|numeric',
            'payment_personnel_id' => 'required|numeric',
            'completion_personnel_id' => 'required|numeric',
            'memo' => 'nullable|string',
            'display_order' => ['required', 'numeric', 'min:0', 'max:' . DisplayOrderEnum::DEFAULT],
            'use_classification' => Rule::in(UseFlagEnum::getValues()),
            'categories' => 'array|min:1',
            'categories.*.name' => 'required|string|max:100|distinct',
        ];

    }

    public function attributes(): array
    {
        return [
            'name' => __('attributes.management_group.name'),
            'sender_post_code' => __('attributes.management_group.sender_post_code'),
            'sender_address_1' => __('attributes.management_group.sender_address_1'),
            'sender_address_2' => __('attributes.management_group.sender_address_2'),
            'sender_address_3' => __('attributes.management_group.sender_address_3'),
            'sender_name' => __('attributes.management_group.sender_name'),
            'contact_point' => __('attributes.management_group.contact_point'),
            'contact_phone' => __('attributes.management_group.contact_phone'),
            'preparatory_personnel_id' => __('attributes.management_group.preparatory_personnel_id'),
            'applicant_id' => __('attributes.management_group.applicant_id'),
            'approver_id' => __('attributes.management_group.approver_id'),
            'final_decision_maker_id' => __('attributes.management_group.final_decision_maker_id'),
            'ordering_personnel_id' => __('attributes.management_group.ordering_personnel_id'),
            'payment_personnel_id' => __('attributes.management_group.payment_personnel_id'),
            'completion_personnel_id' => __('attributes.management_group.completion_personnel_id'),
            'memo' => __('attributes.common.memo'),
            'display_order' => __('attributes.common.display_order'),
            'use_classification' => __('attributes.common.use_classification'),
            'categories.*.name' => __('attributes.management_group.category_name'),
        ];
    }

    public function messages(): array
    {
        return [
            'categories.array' => trans('validation.required', ['attribute' => __('attributes.management_group.category_name')]),
            'categories.min' => trans('validation.required', ['attribute' => __('attributes.management_group.category_name')]),
            'categories.*.name.required' => trans('validation.required', ['attribute' => __('attributes.management_group.category_name')]),
        ];
    }
}
