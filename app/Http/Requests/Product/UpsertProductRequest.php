<?php

namespace App\Http\Requests\Product;

use App\Enums\Common\DisplayOrderEnum;
use App\Enums\Common\UseFlagEnum;
use App\Enums\Product\ProductClassificationEnum;
use App\Enums\Product\TaxRateEnum;
use App\Http\Requests\TimestampRequest;
use App\Models\Product;
use Illuminate\Validation\Rule;

class UpsertProductRequest extends TimestampRequest
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
         * @var Product $product
         */

        $product = request('product');
        $supplierRule = [];
        if (!$product) {
            $supplierRule['supplier_id'] = ['required', 'numeric', Rule::exists('social_suppliers', 'id')];
        }

        return [
            ...parent::rules(),
            ...$supplierRule,
            'product_classification' => ['required', 'numeric', Rule::in(ProductClassificationEnum::getValues())],
            'code' => 'nullable|string|max:20',
            'name' => 'required|string|max:100',
            'unit_price' => 'nullable|numeric',
            'tax_classification_1' => ['required', 'numeric', Rule::in(TaxRateEnum::getValues())],
            'tax_classification_2' => ['required', 'numeric', Rule::in(TaxRateEnum::getValues())],
            'tax_classification_3' => ['required', 'numeric', Rule::in(TaxRateEnum::getValues())],
            'memo' => 'string|nullable',
            'use_classification' => ['required', 'numeric', Rule::in(UseFlagEnum::getValues())],
            'display_order' => ['required', 'numeric', 'min:0', 'max:' . DisplayOrderEnum::DEFAULT],
        ];
    }

    public function attributes(): array
    {
        return [
            'supplier_id' => __('attributes.product.supplier_id'),
            'product_classification' => __('attributes.product.product_classification'),
            'code' => __('attributes.product.code'),
            'name' => __('attributes.product.name'),
            'unit_price' => __('attributes.product.unit_price'),
            'tax_classification_1' => __('attributes.product.tax_classification_1'),
            'tax_classification_2' => __('attributes.product.tax_classification_2'),
            'tax_classification_3' => __('attributes.product.tax_classification_3'),
            'memo' => __('attributes.common.note'),
            'use_classification' => __('attributes.common.use_classification'),
            'display_order' => __('attributes.common.display_order'),
        ];
    }
}
