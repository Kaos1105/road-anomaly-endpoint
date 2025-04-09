<?php

namespace App\Http\Requests\Customer;

use App\Enums\Common\DisplayOrderEnum;
use App\Enums\Common\UseFlagEnum;
use App\Enums\Company\CompanyClassificationEnum;
use App\Enums\SocialCustomer\AccountingCompanyClassificationEnum;
use App\Enums\SocialCustomer\AddressClassificationEnum;
use App\Enums\SocialCustomer\ProcessingSiteClassificationEnum;
use App\Http\Requests\TimestampRequest;
use App\Models\Customer;
use App\Models\Department;
use App\Models\Employee;
use Illuminate\Validation\Rule;

class UpsertCustomerRequest extends TimestampRequest
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
        /**
         * @var Customer $customer
         */

        $customer = request('customer');
        $responsibleEmployeeIds = Employee::select('id')->get()->pluck('id')->toArray();
        $departmentIds = Department::query()->select('id')->whereHas('company', function ($query) {
            $query->where('company_classification', CompanyClassificationEnum::SHINNICHIRO);
        })->get()->pluck('id')->toArray();

        $employeeRule = [];
        if (!$customer) {
            $noneSelectEmployeeIds = Employee::select('id')->whereNotIn('organization_employees.id', function ($query) {
                $query->select('employee_id')->from('social_customers');
            })->get()->pluck('id')->toArray();
            $employeeRule['employee_id'] = ['required', 'numeric', Rule::in($noneSelectEmployeeIds)];
        }

        return [
            ...parent::rules(),
            ...$employeeRule,
            'display_transfer_id' => ['required', 'numeric', Rule::exists('organization_transfers', 'id')],
            'responsible_id' => ['required', 'numeric', Rule::in($responsibleEmployeeIds)],
            'category_name' => 'required|string|max:100',
            'processing_site' => ['required', 'numeric', Rule::in(ProcessingSiteClassificationEnum::getValues())],
            'accounting_company' => ['required', 'numeric', Rule::in(AccountingCompanyClassificationEnum::getValues())],
            'accounting_department_id' => ['required', 'numeric', Rule::in($departmentIds)],
            'address_classification' => ['required', 'numeric', Rule::in(AddressClassificationEnum::getValues())],
            'address_printing_1' => ['boolean'],
            'address_printing_2' => ['boolean'],
            'address_printing_3' => ['boolean'],
            'address_printing_4' => ['boolean'],
            'address_printing_5' => ['boolean'],
            'address_printing_6' => ['boolean'],
            'address_printing_7' => ['boolean'],
            'specified_address_1' => 'nullable|string|max:100',
            'specified_address_2' => 'nullable|string|max:100',
            'specified_address_3' => 'nullable|string|max:100',
            'specified_post_code' => 'nullable|string|max:20',
            'specified_phone' => 'nullable|string|max:20',
            'update_order' => 'string|nullable',
            'memo' => 'string|nullable',
            'use_classification' => ['required', 'numeric', Rule::in(UseFlagEnum::getValues())],
            'display_order' => ['required', 'numeric', 'min:0', 'max:' . DisplayOrderEnum::DEFAULT],
        ];
    }

    public function attributes(): array
    {
        return [
            'employee_id' => __('attributes.customer.employee_id'),
            'display_transfer_id' => __('attributes.customer.display_transfer_id'),
            'responsible_id' => __('attributes.customer.responsible_id'),
            'category_name' => __('attributes.customer.category_name'),
            'processing_site' => __('attributes.customer.processing_site'),
            'accounting_company' => __('attributes.customer.accounting_company'),
            'accounting_department_id' => __('attributes.customer.accounting_department_id'),
            'address_classification' => __('attributes.customer.address_classification'),
            'address_printing_1' => __('attributes.customer.address_printing_1'),
            'address_printing_2' => __('attributes.customer.address_printing_2'),
            'address_printing_3' => __('attributes.customer.address_printing_3'),
            'address_printing_4' => __('attributes.customer.address_printing_4'),
            'address_printing_5' => __('attributes.customer.address_printing_5'),
            'address_printing_6' => __('attributes.customer.address_printing_6'),
            'address_printing_7' => __('attributes.customer.address_printing_7'),
            'specified_address_1' => __('attributes.customer.specified_address_1'),
            'specified_address_2' => __('attributes.customer.specified_address_2'),
            'specified_address_3' => __('attributes.customer.specified_address_3'),
            'specified_post_code' => __('attributes.customer.specified_post_code'),
            'specified_phone' => __('attributes.customer.specified_phone'),
            'update_order' => __('attributes.customer.update_order'),
            'memo' => __('attributes.common.note'),
            'use_classification' => __('attributes.common.use_classification'),
            'display_order' => __('attributes.common.display_order'),
        ];
    }
}
