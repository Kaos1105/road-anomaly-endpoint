<?php

namespace App\Http\Requests\ScreenName;

use App\Enums\Common\DisplayOrderEnum;
use App\Enums\Common\UseFlagEnum;
use App\Enums\ScreenName\DisplayClassificationEnum;
use App\Http\Requests\TimestampRequest;
use Illuminate\Validation\Rule;

class DisplayUpdateRequest extends TimestampRequest
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
        $createRule = [];
        if ($this->checkStoreRequest()) {
            $createRule = [
                'system_id' => ['required', 'numeric', Rule::exists('snet_systems', 'id')],
                'code' => ['required', 'string', 'max:100', Rule::unique('snet_displays', 'code')]
            ];
        }
        return [
            ...parent::rules(),
            ...$createRule,
            'display_classification' => ['required', 'numeric', Rule::in(DisplayClassificationEnum::getValues())],
            'name' => 'required|string|max:100',
            'memo' => 'string|nullable',
            'use_classification' => ['nullable', 'numeric', Rule::in(UseFlagEnum::getValues())],
            'display_order' => ['required', 'numeric', 'min:0', 'max:' . DisplayOrderEnum::DEFAULT],
        ];
    }

    public function attributes(): array
    {
        return [
            'system_id' => __('attributes.system.name'),
            'code' => __('attributes.display.code'),
            'display_classification' => __('attributes.display.display_classification'),
            'name' => __('attributes.display.name'),
            'memo' => __('attributes.common.note'),
            'use_classification' => __('attributes.common.use_classification'),
            'display_order' => __('attributes.common.display_order'),
        ];
    }
}
