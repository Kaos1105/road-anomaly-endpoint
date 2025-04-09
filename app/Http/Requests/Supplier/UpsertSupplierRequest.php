<?php

namespace App\Http\Requests\Supplier;

use App\Enums\Common\DisplayOrderEnum;
use App\Enums\Common\UseFlagEnum;
use App\Enums\Supplier\SupplierClassificationEnum;
use App\Http\Requests\TimestampRequest;
use App\Models\Employee;
use App\Models\Supplier;
use Illuminate\Validation\Rule;

class UpsertSupplierRequest extends TimestampRequest
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
         * @var Supplier $supplier
         */
        $supplier = request('supplier');
        $employeeIds = Employee::select('id')->get()->pluck('id')->toArray();
        if (!$supplier) {
            return [
                ...parent::rules(),
                'sales_store_id' => 'required|numeric|unique:social_suppliers,sales_store_id',
                'supplier_classification' => ['required', 'numeric', Rule::in(SupplierClassificationEnum::getValues())],
                'supplier_person_id' => ['required', 'numeric', Rule::in($employeeIds)],
                'my_company_person_id' => ['required', 'numeric', Rule::in($employeeIds)],
                'memo' => 'string|nullable',
                'use_classification' => ['required', 'numeric', Rule::in(UseFlagEnum::getValues())],
                'display_order' => ['required', 'numeric', 'min:0', 'max:' . DisplayOrderEnum::DEFAULT],
            ];
        }

        return $this->updateRules($supplier, $employeeIds);
    }

    public function updateRules(Supplier $supplier, array $employeeIds): array
    {
        return [
            ...parent::rules(),
            'supplier_classification' => ['required', 'numeric', Rule::in(SupplierClassificationEnum::getValues())],
            'supplier_person_id' => ['required', 'numeric', Rule::in($employeeIds)],
            'my_company_person_id' => ['required', 'numeric', Rule::in($employeeIds)],
            'memo' => 'string|nullable',
            'use_classification' => ['required', 'numeric', Rule::in(UseFlagEnum::getValues())],
            'display_order' => ['required', 'numeric', 'min:0', 'max:' . DisplayOrderEnum::DEFAULT],
        ];
    }

    public function attributes(): array
    {
        return [
            'sales_store_id' => __('attributes.supplier.sales_store_id'),
            'supplier_classification' => __('attributes.supplier.supplier_classification'),
            'supplier_person_id' => __('attributes.supplier.supplier_person_id'),
            'my_company_person_id' => __('attributes.supplier.my_company_person_id'),
            'memo' => __('attributes.common.note'),
            'use_classification' => __('attributes.common.use_classification'),
            'display_order' => __('attributes.common.display_order'),
        ];
    }
}
