<?php

namespace App\Http\Requests\Site;

use App\Http\Requests\TimestampRequest;
use App\Models\Department;
use App\Models\Site;
use Carbon\Carbon;
use Illuminate\Validation\Rule;

class RepresentDepartmentRequest extends TimestampRequest
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
        $department = Department::find($this->input('department_id'));
        $this->merge([
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_by' => \Auth::user()->employee_id,
            'site_id' => $department?->site_id,
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
         * @var Site $site
         */
        $site = request('site');
        return [
            'department_id' => ['required', 'numeric', Rule::exists('organization_departments', 'id')],
            'site_id' => ['required', 'numeric', 'in:' . $site->id],
            'updated_at' => ['string', 'nullable'],
            'updated_by' => ['numeric', 'nullable']
        ];
    }

    public function attributes(): array
    {
        return [
            'department_id' => __('attributes.department.id'),
            'site_id' => __('attributes.department.site_id'),
        ];
    }
}

