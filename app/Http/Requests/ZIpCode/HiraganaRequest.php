<?php

namespace App\Http\Requests\ZIpCode;

use Illuminate\Foundation\Http\FormRequest;

class HiraganaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'app_id' => env('HIRAGANA_APP_ID'),
            'output_type' => 'hiragana',
            'request_id' => substr(md5(time()), 0, 10)
        ]);
    }
    public function rules(): array
    {
        return [
            'app_id' => 'required|string',
            'output_type' => 'required|string',
            'request_id' => 'nullable|string',
            'sentence' => 'required|string',
        ];

    }


    public function attributes(): array
    {
        return [
            'app_id' => __('attributes.external.app_id'),
            'output_type' => __('attributes.external.output_type'),
            'request_id' => __('attributes.external.request_id'),
            'sentence' => __('attributes.external.sentence'),
        ];
    }
}
