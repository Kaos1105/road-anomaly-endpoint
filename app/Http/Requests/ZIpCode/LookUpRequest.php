<?php

namespace App\Http\Requests\ZIpCode;

use Illuminate\Foundation\Http\FormRequest;

class LookUpRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'post_code' => 'required|numeric|min:0|max:9999999',
        ];

    }


    public function attributes(): array
    {
        return [
            'post_code' => __('attributes.site.post_code'),
        ];
    }
}
