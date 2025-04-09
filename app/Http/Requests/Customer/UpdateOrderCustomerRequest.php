<?php

namespace App\Http\Requests\Customer;

use App\Http\Requests\TimestampRequest;

class UpdateOrderCustomerRequest extends TimestampRequest
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
            'update_order' => 'string|nullable',
        ];
    }

    public function attributes(): array
    {
        return [
            'update_order' => __('attributes.customer.update_order'),
        ];
    }
}
