<?php

namespace App\Http\Requests\AccessHistory;

use App\Enums\AccessHistory\AccessActionTypeEnum;
use App\Enums\AccessHistory\AccessibleTypeEnum;
use App\Enums\AccessHistory\ResultClassificationEnum;
use App\Models\System;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpsertAccessHistoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'access_histories' => ['nullable', 'array'],
            'access_histories.*.system_id' => ['required', 'numeric', Rule::in(System::query()->pluck('id'))],
            'access_histories.*.employee_id' => ['nullable', 'numeric'],
            'access_histories.*.accessible_type' => ['nullable', 'string', Rule::in(AccessibleTypeEnum::getValues())],
            'access_histories.*.accessible_id' => ['nullable', 'numeric'],
            'access_histories.*.action' => ['required', 'string', 'max:50', Rule::in(AccessActionTypeEnum::getValues())],
            'access_histories.*.result_classification' => ['required', 'string', 'max:50', Rule::in(ResultClassificationEnum::getValues())],
            'access_histories.*.message' => ['nullable', 'string', 'max:200'],
            'access_histories.*.access_at' => ['string', 'nullable'],
        ];
    }

    public function attributes(): array
    {
        return [
            'system_id' => __('attributes.access_history.system_id'),
            'accessible_type' => __('attributes.access_history.accessible_type'),
            'accessible_id' => __('attributes.access_history.accessible_id'),
            'action' => __('attributes.access_history.action'),
            'result_classification' => __('attributes.access_history.result_classification'),
            'message' => __('attributes.access_history.message')
        ];
    }
}
