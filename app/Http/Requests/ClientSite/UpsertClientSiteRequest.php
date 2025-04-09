<?php

namespace App\Http\Requests\ClientSite;

use App\Enums\Common\DisplayOrderEnum;
use App\Enums\Common\UseFlagEnum;
use App\Http\Requests\TimestampRequest;
use Illuminate\Validation\Rule;

class UpsertClientSiteRequest extends TimestampRequest
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
            $rule = [
                'site_id' => Rule::exists('organization_sites', 'id'),
                'management_department_id' => Rule::exists('negotiation_management_departments', 'id'),
            ];
        }

        return [
            ...parent::rules(),
            ...$rule,
            'memo' => 'nullable|string',
            'display_order' => ['nullable', 'numeric', 'min:0', 'max:' . DisplayOrderEnum::DEFAULT],
            'use_classification' => ['nullable', Rule::in(UseFlagEnum::getValues())],
        ];
    }

    public function attributes(): array
    {
        return [
            'site_id' => __('attributes.site.id'),
            'management_department_id' => __('attributes.management_department.id'),
            'memo' => __('attributes.common.memo'),
            'display_order' => __('attributes.common.display_order'),
            'use_classification' => __('attributes.common.use_classification')
        ];
    }
}
