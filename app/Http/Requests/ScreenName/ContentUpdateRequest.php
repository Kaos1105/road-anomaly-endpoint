<?php

namespace App\Http\Requests\ScreenName;

use App\Enums\AccessPermission\Permission1FlagEnum;
use App\Enums\AccessPermission\Permission2FlagEnum;
use App\Enums\AccessPermission\Permission3FlagEnum;
use App\Enums\AccessPermission\Permission4FlagEnum;
use App\Enums\Common\DisplayOrderEnum;
use App\Enums\Common\UseFlagEnum;
use App\Enums\ScreenName\ContentClassificationEnum;
use App\Http\Requests\TimestampRequest;
use App\Rules\ContentNoUniqueRule;
use Illuminate\Validation\Rule;

class ContentUpdateRequest extends TimestampRequest
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
                'display_id' => ['required', 'numeric', Rule::exists('snet_displays', 'id')],
                'no' => ['required', 'string', new ContentNoUniqueRule($this->input('display_id'))]
            ];
        }
        return [
            ...parent::rules(),
            ...$createRule,
            'classification' => ['required', 'numeric', Rule::in(ContentClassificationEnum::getValues())],
            'name' => 'required|string|max:100',
            'permission_1' => ['required', 'numeric', Rule::in(Permission1FlagEnum::getValues())],
            'permission_2' => ['required', 'numeric', Rule::in(Permission2FlagEnum::getValues())],
            'permission_3' => ['required', 'numeric', Rule::in(Permission3FlagEnum::getValues())],
            'permission_4' => ['required', 'numeric', Rule::in(Permission4FlagEnum::getValues())],
            'memo' => 'string|nullable',
            'use_classification' => ['nullable', 'numeric', Rule::in(UseFlagEnum::getValues())],
            'display_order' => ['required', 'numeric', 'min:0', 'max:' . DisplayOrderEnum::DEFAULT],
        ];
    }

    public function attributes(): array
    {
        return [
            'no' => __('attributes.content.no'),
            'classification' => __('attributes.content.classification'),
            'name' => __('attributes.content.name'),
            'permission_1' => __('attributes.content.permission_1'),
            'permission_2' => __('attributes.content.permission_2'),
            'permission_3' => __('attributes.content.permission_3'),
            'permission_4' => __('attributes.content.permission_4'),
            'memo' => __('attributes.common.note'),
            'use_classification' => __('attributes.common.use_classification'),
            'display_order' => __('attributes.common.display_order'),
        ];
    }
}
