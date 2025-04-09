<?php

namespace App\Http\Requests\Employee;

use App\Enums\Common\DisplayOrderEnum;
use App\Enums\Common\PreviousNameFlagEnum;
use App\Enums\Common\UseFlagEnum;
use App\Enums\Employee\EmployeeClassificationEnum;
use App\Enums\Employee\GenderEnum;
use App\Enums\Employee\PeriodAccuracyFlagEnum;
use App\Http\Requests\TimestampRequest;
use Illuminate\Validation\Rule;

class UpsertEmployeeRequest extends TimestampRequest
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
        $dayOfBirthRule = ['date', 'nullable', 'max:10'];
        if ($this->request->get('day_of_death')) {
            $dayOfBirthRule[] = 'before_or_equal:day_of_death';
        }
        if ($this->checkStoreRequest()) {
            $parentsIdRule = [
                'company_id' => ['required', 'numeric', Rule::exists('organization_companies', 'id')],
                'site_id' => ['nullable', 'numeric', Rule::exists('organization_sites', 'id')],
                'department_id' => ['nullable', 'numeric', Rule::exists('organization_departments', 'id')],
                'division_id' => ['nullable', 'numeric', Rule::exists('organization_divisions', 'id')],
            ];
        }
        return [
            ...parent::rules(),
            ...$parentsIdRule,
            'code' => 'nullable|string|max:20',
            'last_name' => 'required|string|min:1|max:100',
            'first_name' => 'required|string|max:100',
            'kana' => 'nullable|string|max:100',
            'day_of_birth' => $dayOfBirthRule,
            'day_of_death' => 'nullable|date|max:10|after_or_equal:day_of_birth',
            'period_accuracy_flg' => Rule::in(PeriodAccuracyFlagEnum::getValues()),
            'employees_classification' => Rule::in(EmployeeClassificationEnum::getValues()),
            'maiden_name' => 'nullable|string|max:100',
            'previous_name_flg' => ['nullable', Rule::in(PreviousNameFlagEnum::getValues())],
            'gender' => ['nullable', Rule::in(GenderEnum::getValues())],
            'en_notation' => 'nullable|string|max:100',
            'company_email' => 'nullable|string|max:100',
            'company_phone' => 'nullable|string|max:20',
            'post_code' => 'nullable|string|max:20',
            'address_1' => 'nullable|string|max:100',
            'address_2' => 'nullable|string|max:100',
            'address_3' => 'nullable|string|max:100',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|string|max:100',
            'memo' => 'nullable|string',
            'display_order' => ['required', 'numeric', 'min:0', 'max:' . DisplayOrderEnum::DEFAULT],
            'use_classification' => Rule::in(UseFlagEnum::getValues()),
            'update_history' => 'nullable|string',
            'biography' => 'nullable|string',
        ];
    }

    public function attributes(): array
    {
        return [
            'code' => __('attributes.employee.code'),
            'last_name' => __('attributes.employee.last_name'),
            'first_name' => __('attributes.employee.first_name'),
            'kana' => __('attributes.employee.kana'),
            'day_of_birth' => __('attributes.employee.day_of_birth'),
            'day_of_death' => __('attributes.employee.day_of_death'),
            'period_accuracy_flg' => __('attributes.employee.period_accuracy_flg'),
            'employees_classification' => __('attributes.employee.employees_classification'),
            'maiden_name' => __('attributes.employee.maiden_name'),
            'previous_name_flg' => __('attributes.employee.previous_name_flg'),
            'gender' => __('attributes.employee.gender'),
            'en_notation' => __('attributes.employee.en_notation'),
            'company_email' => __('attributes.employee.company_email'),
            'company_phone' => __('attributes.employee.company_phone'),
            'post_code' => __('attributes.employee.post_code'),
            'address_1' => __('attributes.employee.address_1'),
            'address_2' => __('attributes.employee.address_2'),
            'address_3' => __('attributes.employee.address_3'),
            'phone' => __('attributes.employee.phone'),
            'email' => __('attributes.employee.email'),
            'memo' => __('attributes.employee.memo'),
            'display_order' => __('attributes.common.display_order'),
            'use_classification' => __('attributes.common.use_classification'),
            'company_id' => __('attributes.company.id'),
            'site_id' => __('attributes.transfer.department_id'),
            'department_id' => __('attributes.site.id'),
            'division_id' => __('attributes.division.id')
        ];
    }
}
