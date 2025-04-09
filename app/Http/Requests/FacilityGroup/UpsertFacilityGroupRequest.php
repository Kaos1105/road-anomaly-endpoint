<?php

namespace App\Http\Requests\FacilityGroup;

use App\Enums\Common\DisplayOrderEnum;
use App\Enums\Common\UseFlagEnum;
use App\Http\Requests\TimestampRequest;
use App\Models\FacilityGroup;

use Illuminate\Validation\Rule;

class UpsertFacilityGroupRequest extends TimestampRequest
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
         * @var $group FacilityGroup
         */
        $group = request('group');

        return [
            ...parent::rules(),
            'name' => ['required', 'string', 'max:100', Rule::unique('facility_facility_groups', 'name')->ignore($group?->id)],
            'use_group_id' => ['required', 'numeric', Rule::exists('main_groups', 'id')],
            'display_order' => ['required', 'numeric', 'min:0', 'max:' . DisplayOrderEnum::DEFAULT],
            'use_classification' => Rule::in(UseFlagEnum::getValues()),
            'memo' => ['string', 'nullable']
        ];

    }

    public function attributes(): array
    {
        return [
            'name' => __('attributes.facility_group.name'),
            'use_group_id' => __('attributes.facility_group.use_group_id'),
            'display_order' => __('attributes.common.display_order'),
            'use_classification' => __('attributes.common.use_classification'),
            'memo' => __('attributes.common.memo'),
        ];
    }
}
