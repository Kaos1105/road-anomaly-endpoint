<?php

namespace App\Http\Requests\Contract;

use App\Enums\Common\DisplayOrderEnum;
use App\Enums\Common\UseFlagEnum;
use App\Http\Requests\TimestampRequest;
use App\Models\BasicContract;
use Illuminate\Validation\Rule;


class UpsertBasicContractRequest extends TimestampRequest
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
         * @var $basicContract BasicContract
         */
        $basicContract = request('basic_contract');

        return [
            ...parent::rules(),
            'code' => ['required', 'string', 'max:20', Rule::unique('contract_basic_contracts', 'code')->ignore($basicContract?->id)],
            'no' => 'nullable|string|max:50',
            'name' => 'required|string|min:1|max:100',
            'counterparty_id' => ['required', Rule::exists('organization_sites', 'id')],
            'counterparty_contractor_id' => ['nullable', Rule::exists('organization_employees', 'id')],
            'counterparty_representative_id' => ['nullable', Rule::exists('organization_employees', 'id')],
            'site_id' => ['required', Rule::exists('organization_sites', 'id')],
            'contractor_id' => ['required', Rule::exists('organization_employees', 'id')],
            'representative_id' => ['required', Rule::exists('organization_employees', 'id')],
            'signing_at' => 'required|date|max:10',
            'memo' => 'nullable|string',
            'display_order' => ['required', 'numeric', 'max:' . DisplayOrderEnum::DEFAULT],
            'use_classification' => Rule::in(UseFlagEnum::getValues()),
        ];
    }

    public function attributes(): array
    {
        return [
            'code' => __('attributes.basic_contract.code'),
            'no' => __('attributes.basic_contract.no'),
            'name' => __('attributes.basic_contract.name'),
            'counterparty_id' => __('attributes.basic_contract.counterparty_id'),
            'counterparty_contractor_id' => __('attributes.basic_contract.counterparty_contractor_id'),
            'counterparty_representative_id' => __('attributes.basic_contract.counterparty_representative_id'),
            'site_id' => __('attributes.basic_contract.site_id'),
            'contractor_id' => __('attributes.basic_contract.contractor_id'),
            'representative_id' => __('attributes.basic_contract.representative_id'),
            'signing_at' => __('attributes.basic_contract.signing_at'),
            'memo' => __('attributes.employee.memo'),
            'display_order' => __('attributes.common.display_order'),
            'use_classification' => __('attributes.common.use_classification'),
        ];
    }

}
