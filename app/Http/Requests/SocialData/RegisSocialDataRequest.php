<?php

namespace App\Http\Requests\SocialData;

use App\Models\Customer;
use App\Models\SocialData;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegisSocialDataRequest extends FormRequest
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
            'social_social_datas' => ['nullable', 'array'],
            'social_social_datas.*.customer_id' =>
                ['numeric', 'required', Rule::in(Customer::query()->pluck('id'))],
            'social_social_datas.*.previous_social_data_id' =>
                ['numeric', 'nullable', Rule::in(SocialData::query()->pluck('id'))],
        ];
    }

    public function attributes(): array
    {
        return [
            'social_social_datas.*.customer_id' => __('attributes.social_data.customer_id'),
        ];
    }
}
