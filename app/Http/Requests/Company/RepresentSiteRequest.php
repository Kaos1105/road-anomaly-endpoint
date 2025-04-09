<?php

namespace App\Http\Requests\Company;

use App\Http\Requests\TimestampRequest;
use App\Models\Company;
use App\Models\Site;
use Carbon\Carbon;
use Illuminate\Validation\Rule;

class RepresentSiteRequest extends TimestampRequest
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
        $site = Site::find($this->input('site_id'));
        $this->merge([
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_by' => \Auth::user()->employee_id,
            'company_id' => $site?->company_id,
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
         * @var $company Company
         */
        $company = request('company');
        return [
            'site_id' => ['required', 'numeric', Rule::exists('organization_sites', 'id')],
            'company_id' => ['required', 'numeric', 'in:' . $company->id],
            'updated_at' => ['string', 'nullable'],
            'updated_by' => ['numeric', 'nullable']
        ];
    }

    public function attributes(): array
    {
        return [
            'company_id' => __('attributes.company.id'),
            'site_id' => __('attributes.site.id'),
        ];
    }
}

