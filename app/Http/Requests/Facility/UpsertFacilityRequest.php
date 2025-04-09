<?php

namespace App\Http\Requests\Facility;

use App\Enums\Common\DisplayOrderEnum;
use App\Enums\Common\UseFlagEnum;
use App\Enums\Facility\AggregationClassificationEnum;
use App\Enums\Facility\FacilityClassificationEnum;
use App\Http\Requests\TimestampRequest;
use App\Models\Facility;

use Illuminate\Validation\Rule;

class UpsertFacilityRequest extends TimestampRequest
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
         * @var $facility Facility
         */
        $facility = request('facility');

        return [
            ...parent::rules(),
            'facility_group_id' => ['required', 'numeric', Rule::exists('facility_facility_groups', 'id')],
            'facility_classification' => ['required', 'numeric', Rule::in(FacilityClassificationEnum::getValues())],
            'name' => ['required', 'string', 'max:100',
                Rule::unique('facility_facilities', 'name')
                    ->where(function ($query) {
                        return $query->where('facility_group_id', $this->input('facility_group_id'));
                    })
                    ->ignore($facility?->id)
            ],
            'usage_method' => ['string', 'nullable'],
            'responsible_user_id' => ['required', 'numeric', Rule::exists('organization_employees', 'id')],
            'memo' => ['string', 'nullable'],
            'display_order' => ['required', 'numeric', 'min:0', 'max:' . DisplayOrderEnum::DEFAULT],
            'aggregation_classification' => Rule::in(AggregationClassificationEnum::getValues()),
            'use_classification' => Rule::in(UseFlagEnum::getValues()),
        ];

    }

    public function attributes(): array
    {
        return [
            'facility_group_id' => __('attributes.facility.facility_group_id'),
            'facility_classification' => __('attributes.facility.facility_classification'),
            'name' => __('attributes.facility.name'),
            'usage_method' => __('attributes.facility.usage_method'),
            'responsible_user_id' => __('attributes.facility.responsible_user_id'),
            'aggregation_classification' => __('attributes.facility.aggregation_classification'),
            'display_order' => __('attributes.common.display_order'),
            'memo' => __('attributes.common.memo'),
            'use_classification' => __('attributes.common.use_classification'),
        ];
    }
}
