<?php

namespace App\Http\Requests\Transfer;

use App\Enums\Common\DisplayOrderEnum;
use App\Enums\Common\RepresentFlagEnum;
use App\Enums\Transfer\ContractClassificationEnum;
use App\Enums\Transfer\MajorHistoryEnum;
use App\Enums\Transfer\TransferClassificationEnum;
use App\Http\Requests\TimestampRequest;
use Illuminate\Validation\Rule;

class UpsertTransferRequest extends TimestampRequest
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
        $parentsIdRule = [];
        $startDateRule = ['nullable', 'date', 'max:10'];
        $endDateRule = ['nullable', 'date', 'max:10'];
        if ($this->request->get('start_date') && $this->request->get('end_date')) {
            $startDateRule = [...$startDateRule, 'before_or_equal:end_date'];
            $endDateRule = [...$endDateRule, 'after_or_equal:start_date'];
        }
        if ($this->checkStoreRequest()) {
            $parentsIdRule = [
                'employee_id' => ['required', 'numeric', Rule::exists('organization_employees', 'id')],
                'company_id' => ['required', 'numeric', Rule::exists('organization_companies', 'id')],
                'site_id' => ['nullable', 'numeric', Rule::exists('organization_sites', 'id')],
                'department_id' => ['nullable', 'numeric', Rule::exists('organization_departments', 'id')],
                'division_id' => ['nullable', 'numeric', Rule::exists('organization_divisions', 'id')],
            ];
        }
        return [
            ...parent::rules(),
            ...$parentsIdRule,
            'team_name' => 'nullable|string|min:1|max:100',
            'position' => 'nullable|string|min:1|max:100',
            'contract_classification' => ['required', Rule::in(ContractClassificationEnum::getValues())],
            'start_date' => $startDateRule,
            'end_date' => $endDateRule,
            'represent_flg' => Rule::in(RepresentFlagEnum::getValues()),
            'major_history_flg' => Rule::in(MajorHistoryEnum::getValues()),
            'transfer_classification' => Rule::in(TransferClassificationEnum::getValues()),
            'memo' => 'nullable|string',
            'display_order' => ['required', 'numeric', 'min:0', 'max:' . DisplayOrderEnum::DEFAULT],
        ];
    }

    public function attributes(): array
    {
        return [
            'employee_id' => __('attributes.employee.id'),
            'company_id' => __('attributes.company.id'),
            'site_id' => __('attributes.transfer.department_id'),
            'department_id' => __('attributes.site.id'),
            'division_id' => __('attributes.division.id'),
            'team_name' => __('attributes.transfer.team_name'),
            'position' => __('attributes.transfer.position'),
            'contract_classification' => __('attributes.transfer.contract_classification'),
            'start_date' => __('attributes.transfer.start_date'),
            'end_date' => __('attributes.transfer.end_date'),
            'major_history_flg' => __('attributes.transfer.major_history_flg'),
            'transfer_classification' => __('attributes.transfer.transfer_classification'),
            'memo' => __('attributes.transfer.memo'),
            'display_order' => __('attributes.common.display_order'),
            'use_classification' => __('attributes.common.use_classification')
        ];
    }
}

