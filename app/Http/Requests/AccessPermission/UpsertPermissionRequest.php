<?php

namespace App\Http\Requests\AccessPermission;

use App\Models\AccessPermission;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpsertPermissionRequest extends FormRequest
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
            'access_permissions.*.employee_id' => ['numeric', 'required'],
            'access_permissions.*.system_id' => ['numeric', 'required'],
            'access_permissions.*.permission_2' => ['numeric', 'required'],
            'access_permissions.*.permission_3' => ['numeric', 'required'],
            'access_permissions.*.permission_4' => ['numeric', 'required'],
        ];
    }

    public function attributes(): array
    {
        return [
            'access_permissions.*.permission_2' => __('attributes.access_permissions.permission_2'),
            'access_permissions.*.permission_3' => __('attributes.access_permissions.permission_3'),
            'access_permissions.*.permission_4' => __('attributes.access_permissions.permission_4'),
        ];
    }
}
