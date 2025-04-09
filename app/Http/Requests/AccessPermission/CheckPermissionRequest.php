<?php

namespace App\Http\Requests\AccessPermission;

use App\Models\AccessPermission;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CheckPermissionRequest extends FormRequest
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
            'access_permissions' => ['nullable', 'array'],
            'access_permissions.*.id' => ['numeric', 'required', Rule::in(AccessPermission::query()->pluck('id'))],
            'access_permissions.*.start_date' => ['nullable', 'date'],
            'access_permissions.*.end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'access_permissions.*.permission_1' => ['numeric', 'required'],
        ];
    }

    public function attributes(): array
    {
        return [
            'access_permissions.*.permission_1' => __('attributes.access_permissions.permission_1'),
            'access_permissions.*.start_date' => __('attributes.access_permissions.start_date'),
            'access_permissions.*.end_date' => __('attributes.access_permissions.end_date'),
        ];
    }
}
