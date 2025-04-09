<?php

namespace App\Http\Requests\ScreenName;

use App\Enums\Common\DisplayOrderEnum;
use App\Enums\Common\UseFlagEnum;
use App\Enums\ScreenName\DisplayClassificationEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UpsertBatchDisplayRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function checkStoreRequest(): bool
    {
        return Request::isMethod(self::METHOD_POST);
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'code' => ['required', 'string', 'max:100'],
            'display_classification' => ['required', 'numeric', Rule::in(DisplayClassificationEnum::getValues())],
            'name' => 'required|string|max:100',
            'memo' => 'string|nullable',
            'use_classification' => ['required', 'numeric', Rule::in(UseFlagEnum::getValues())],
            'display_order' => ['required', 'numeric', 'min:0', 'max:' . DisplayOrderEnum::DEFAULT],
            'updated_at' => ['string', 'nullable'],
            'updated_by' => ['numeric', 'nullable'],
            'created_by' => ['numeric', 'nullable'],
            'created_at' => ['string', 'nullable'],
        ];
    }

    public function attributes(): array
    {
        return [
            'code' => __('attributes.display.code'),
            'display_classification' => __('attributes.display.display_classification'),
            'name' => __('attributes.display.name'),
            'memo' => __('attributes.common.note'),
            'use_classification' => __('attributes.common.use_classification'),
            'display_order' => __('attributes.common.display_order'),
        ];
    }
}
