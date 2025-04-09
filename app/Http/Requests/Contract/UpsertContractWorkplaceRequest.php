<?php

namespace App\Http\Requests\Contract;

use App\Enums\Common\DisplayOrderEnum;
use App\Enums\Common\UseFlagEnum;
use App\Http\Requests\TimestampRequest;
use App\Models\BasicContract;
use App\Rules\DivisionWorkplaceExistsRule;
use Illuminate\Validation\Rule;

class UpsertContractWorkplaceRequest extends TimestampRequest
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
        $basicRules = [];

        if ($this->checkStoreRequest()) {
            /**
             * @var $basicContract BasicContract
             */
            $basicContract = request('basic_contract');
            $basicRules['division_id'] = ['required', Rule::exists('organization_divisions', 'id'), new DivisionWorkplaceExistsRule($basicContract->id)];
        }

        return [
            ...parent::rules(),
            ...$basicRules,
            'memo' => 'nullable|string',
            'display_order' => ['required', 'numeric', 'max:' . DisplayOrderEnum::DEFAULT],
            'use_classification' => Rule::in(UseFlagEnum::getValues()),
        ];
    }

    public function attributes(): array
    {
        return [
            'id' => __('attributes.contract_workplace.id'),
            'division_id' => __('attributes.contract_workplace.division_id'),
            'memo' => __('attributes.employee.memo'),
            'display_order' => __('attributes.common.display_order'),
            'use_classification' => __('attributes.common.use_classification'),
        ];
    }

}
