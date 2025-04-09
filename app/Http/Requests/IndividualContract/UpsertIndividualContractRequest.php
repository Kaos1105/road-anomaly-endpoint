<?php

namespace App\Http\Requests\IndividualContract;

use App\Enums\Common\DisplayOrderEnum;
use App\Enums\Common\UseFlagEnum;
use App\Enums\Contract\RoundingMethodEnum;
use App\Enums\Contract\UnitClassificationEnum;
use App\Http\Requests\TimestampRequest;
use Illuminate\Validation\Rule;

class UpsertIndividualContractRequest extends TimestampRequest
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
     */
    public function rules(): array
    {

        return [
            ...parent::rules(),
            'basic_contract_id' => ['required', 'numeric', Rule::exists('contract_basic_contracts', 'id')],
            'name' => ['required', 'string', 'min:1', 'max:100'],
            'unit_price' => 'numeric|required',
            'unit_classification' => ['required', 'numeric', Rule::in(UnitClassificationEnum::getValues())],
            'unit_name' => 'nullable|string|max:20',
            'rounding_method' => ['required', 'numeric', Rule::in(RoundingMethodEnum::getValues())],
            'start_date' => 'date|required|max:10',
            'end_date' => 'date|required|max:10|after_or_equal:period_start',
            'memo' => 'nullable|string',
            'display_order' => ['numeric', 'nullable', 'min:0', 'max:' . DisplayOrderEnum::DEFAULT],
            'use_classification' => ['required', 'numeric', Rule::in(UseFlagEnum::getValues())],
        ];
    }

    public function attributes(): array
    {
        return [
            'basic_contract_id' => __('attributes.individual_contract.basic_contract_id'),
            'name' => __('attributes.individual_contract.name'),
            'unit_price' => __('attributes.individual_contract.unit_price'),
            'unit_classification' => __('attributes.individual_contract.unit_classification'),
            'unit_name' => __('attributes.individual_contract.unit_name'),
            'rounding_method' => __('attributes.individual_contract.rounding_method'),
            'start_date' => __('attributes.individual_contract.period_start'),
            'end_date' => __('attributes.individual_contract.period_end'),
            'memo' => __('attributes.common.note'),
            'use_classification' => __('attributes.common.use_classification'),
            'display_order' => __('attributes.common.display_order'),
        ];
    }
}
