<?php

namespace App\Http\Requests\SocialData;

use App\Enums\Common\DisplayOrderEnum;
use App\Enums\Common\UseFlagEnum;
use App\Enums\Product\TaxRateEnum;
use App\Enums\SocialCustomer\AccountingCompanyClassificationEnum;
use App\Enums\SocialCustomer\AddressClassificationEnum;
use App\Enums\SocialCustomer\ProcessingSiteClassificationEnum;
use App\Http\Requests\TimestampRequest;
use App\Models\Department;
use App\Models\Product;
use Illuminate\Validation\Rule;

class UpdateSocialDataRequest extends TimestampRequest
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
        $productIds = Product::query()->get()->pluck('id')->toArray();
        $departmentIds = Department::query()->get()->pluck('id')->toArray();
        return [
            ...parent::rules(),
            'product_id' => ['required', 'numeric', Rule::in($productIds)],
            'product_name' => ['required', 'string', 'min:1', 'max:100'],
            'unit_price' => 'nullable|numeric',
            'discount' => 'nullable|numeric',
            'tax_classification_1' => ['required', 'numeric', Rule::in(TaxRateEnum::getValues())],
            'tax_1' => 'nullable|numeric',
            'shipping_cost' => 'nullable|numeric',
            'tax_classification_2' => ['required', 'numeric', Rule::in(TaxRateEnum::getValues())],
            'tax_2' => 'nullable|numeric',
            'other' => 'nullable|numeric',
            'tax_classification_3' => ['required', 'numeric', Rule::in(TaxRateEnum::getValues())],
            'tax_3' => 'nullable|numeric',
            'total_amount' => 'nullable|numeric',
            'total_tax' => 'nullable|numeric',
            'purpose' => 'nullable|string',
            'result' => 'nullable|string',
            'processing_site' => ['required', 'numeric', Rule::in(ProcessingSiteClassificationEnum::getValues())],
            'accounting_company' => ['required', 'numeric', Rule::in(AccountingCompanyClassificationEnum::getValues())],
            'accounting_department_id' => ['required', 'numeric', Rule::in($departmentIds)],
            'address_classification' => ['required', 'numeric', Rule::in(AddressClassificationEnum::getValues())],
            'memo' => 'nullable|string',
            'display_order' => ['numeric', 'nullable', 'min:0', 'max:' . DisplayOrderEnum::DEFAULT],
            'use_classification' => ['required', 'numeric', Rule::in(UseFlagEnum::getValues())],
        ];
    }

    public function attributes(): array
    {
        return [
            'product_id' => __('attributes.social_data.product_id'),
            'product_name' => __('attributes.social_data.product_name'),
            'unit_price' => __('attributes.social_data.unit_price'),
            'discount' => __('attributes.social_data.discount'),
            'tax_classification_1' => __('attributes.social_data.tax_classification_1'),
            'tax_1' => __('attributes.social_data.tax_1'),
            'shipping_cost' => __('attributes.social_data.shipping_cost'),
            'tax_classification_2' => __('attributes.social_data.tax_classification_2'),
            'tax_2' => __('attributes.social_data.tax_2'),
            'other' => __('attributes.social_data.other'),
            'tax_classification_3' => __('attributes.social_data.tax_classification_3'),
            'tax_3' => __('attributes.social_data.tax_3'),
            'total_amount' => __('attributes.social_data.total_amount'),
            'total_tax' => __('attributes.social_data.total_tax'),
            'purpose' => __('attributes.social_data.purpose'),
            'result' => __('attributes.social_data.result'),
            'processing_site' => __('attributes.social_data.processing_site'),
            'accounting_company' => __('attributes.social_data.accounting_company'),
            'accounting_department_id' => __('attributes.social_data.accounting_department_id'),
            'address_classification' => __('attributes.social_data.address_classification'),
            'memo' => __('attributes.common.note'),
            'use_classification' => __('attributes.common.use_classification'),
            'display_order' => __('attributes.common.display_order'),
        ];
    }
}
