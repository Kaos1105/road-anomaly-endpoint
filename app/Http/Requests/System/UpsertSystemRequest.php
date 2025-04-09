<?php

namespace App\Http\Requests\System;

use App\Enums\AccessPermission\Permission2FlagEnum;
use App\Enums\AccessPermission\Permission3FlagEnum;
use App\Enums\AccessPermission\Permission4FlagEnum;
use App\Enums\Common\DisplayOrderEnum;
use App\Enums\Common\UseFlagEnum;
use App\Http\Requests\TimestampRequest;
use App\Models\System;
use Illuminate\Validation\Rule;

class UpsertSystemRequest extends TimestampRequest
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
         * @var System $system
         */
        $system = request('system');
        $startDateRule = ['date', 'required'];
        if ($this->request->get('end_date')) {
            $startDateRule[] = 'before_or_equal:end_date';
        }
        if (!$system) {
            return [
                ...parent::rules(),
                'code' => 'required|string|max:100|unique:snet_systems,code',
                'name' => 'required|string|max:100',
                'overview' => 'string|nullable',
                'start_date' => $startDateRule,
                'end_date' => 'nullable|date|after_or_equal:start_date',
                'default_permission_2' => ['numeric', 'required', Rule::in(Permission2FlagEnum::getValues())],
                'default_permission_3' => ['numeric', 'required', Rule::in(Permission3FlagEnum::getValues())],
                'default_permission_4' => ['numeric', 'required', Rule::in(Permission4FlagEnum::getValues())],
                'memo' => 'string|nullable',
                'use_classification' => ['numeric', 'nullable', Rule::in(UseFlagEnum::getValues())],
                'display_order' => ['required', 'numeric', 'min:0', 'max:' . DisplayOrderEnum::DEFAULT],
            ];
        }

        return $this->updateRules($system);
    }

    public function updateRules(System $system): array
    {
        $startDateRule = ['date', 'required'];
        if ($this->request->get('end_date')) {
            $startDateRule[] = 'before_or_equal:end_date';
        }
        return [
            ...parent::rules(),
            'name' => 'nullable|string|max:100',
            'overview' => 'string|nullable',
            'start_date' => $startDateRule,
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'default_permission_2' => ['numeric', 'nullable', Rule::in(Permission2FlagEnum::getValues())],
            'default_permission_3' => ['numeric', 'nullable', Rule::in(Permission3FlagEnum::getValues())],
            'default_permission_4' => ['numeric', 'nullable', Rule::in(Permission4FlagEnum::getValues())],
            'memo' => 'string|nullable',
            'use_classification' => ['numeric', 'nullable', Rule::in(UseFlagEnum::getValues())],
            'display_order' => ['required', 'numeric', 'min:0', 'max:' . DisplayOrderEnum::DEFAULT],
        ];
    }

    public function attributes(): array
    {
        return [
            'code' => __('attributes.system.code'),
            'name' => __('attributes.system.name'),
            'start_date' => __('attributes.system.name'),
            'end_date' => __('attributes.system.name'),
            'default_permission_2' => __('attributes.system.name'),
            'default_permission_3' => __('attributes.system.name'),
            'default_permission_4' => __('attributes.system.name'),
            'memo' => __('attributes.common.note'),
            'use_classification' => __('attributes.common.use_classification'),
            'display_order' => __('attributes.common.display_order'),
        ];
    }
}
