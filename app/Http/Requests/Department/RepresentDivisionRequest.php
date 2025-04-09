<?php

namespace App\Http\Requests\Department;

use App\Models\Department;
use App\Models\Division;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RepresentDivisionRequest extends FormRequest
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
        $division = Division::find($this->input('division_id'));
        $this->merge([
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_by' => \Auth::user()->employee_id,
            'department_id' => $division?->department_id,
        ]);
    }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        /**
         * @var Department $department
         */
        $department = request('department');
        return [
            'division_id' => ['required', 'numeric', Rule::exists('organization_divisions', 'id')],
            'department_id' => ['required', 'numeric', 'in:' . $department->id],
            'updated_at' => ['string', 'nullable'],
            'updated_by' => ['numeric', 'nullable']
        ];
    }

    public function attributes(): array
    {
        return [
            'division_id' => __('attributes.division.id'),
            'department_id' => __('attributes.division.department_id'),
        ];
    }
}

