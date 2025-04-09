<?php

namespace App\Http\Requests\AccessPermission;

use App\Models\AccessPermission;
use App\Models\Employee;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpsertPermission1Request extends FormRequest
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
        /**
         * @var Employee $employee
         */
        $employee = request('employee');
        // Merge the employee_id into each access_permission item
        if ($this->has('access_permissions')) {
            $this->merge([
                'access_permissions' => collect($this->input('access_permissions'))->map(function ($item) use ($employee) {
                    return array_merge($item, ['employee_id' => $employee->id]);
                })->toArray(),
            ]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'access_permissions' => ['nullable', 'array'],
            'access_permissions.*.id' => ['nullable', 'nullable', Rule::in(AccessPermission::query()->pluck('id'))],
            'access_permissions.*.employee_id' => ['numeric', 'required'],
            'access_permissions.*.system_id' => ['numeric', 'required'],
            'access_permissions.*.permission_1' => ['numeric', 'required'],
            'access_permissions.*.start_date' => ['nullable', 'date'],
            'access_permissions.*.end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
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
