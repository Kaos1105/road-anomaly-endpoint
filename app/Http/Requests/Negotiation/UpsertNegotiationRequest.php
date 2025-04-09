<?php

namespace App\Http\Requests\Negotiation;

use App\Enums\Common\DateTimeEnum;
use App\Enums\Negotiation\ProgressClassificationEnum;
use App\Http\Requests\TimestampRequest;
use Carbon\Carbon;
use Illuminate\Validation\Rule;

class UpsertNegotiationRequest extends TimestampRequest
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
        parent::prepareForValidation();
        if (!empty($this->input('client_employee_ids')) && is_string($this->input('client_employee_ids'))) {
            $this->merge(['client_employee_ids' => explode(',', $this->input('client_employee_ids'))]);
        }
        if (!empty($this->input('my_company_employee_ids')) && is_string($this->input('my_company_employee_ids'))) {
            $this->merge(['my_company_employee_ids' => explode(',', $this->input('my_company_employee_ids'))]);
        }
        $this->merge([
            'date_time' => $this->input('date_time') ? Carbon::parse($this->input('date_time', DateTimeEnum::DATE_TIME_FORMAT_V1))->toDateTimeString() : null,
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            ...parent::rules(),
            'client_site_id' => ['required', 'numeric', Rule::exists('negotiation_client_sites', 'id')],
            'client_employee_ids' => 'nullable|array',
            'client_employee_ids.*' => Rule::exists('negotiation_client_employees', 'id'),
            'date_time' => 'required|date_format:Y-m-d H:i:s',
            'purpose' => 'nullable|string',
            'progress_classification' => ['required', Rule::in(ProgressClassificationEnum::getValues())],
            'result' => 'nullable|string',
            'my_company_employee_ids' => 'required|array|min:1',
            'my_company_employee_ids.*' => Rule::exists('negotiation_my_company_employees', 'id'),
        ];
    }

    public function attributes(): array
    {
        return [
            'client_site_id' => __('attributes.negotiation.client_site_id'),
            'client_employee_ids' => __('attributes.negotiation.client_employee_ids'),
            'client_employee_ids.*' => __('attributes.negotiation.client_employee_ids'),
            'date_time' => __('attributes.negotiation.date_time'),
            'purpose' => __('attributes.negotiation.purpose'),
            'progress_classification' => __('attributes.negotiation.progress_classification'),
            'result' => __('attributes.negotiation.result'),
            'my_company_employee_ids' => __('attributes.negotiation.my_company_employee_ids'),
            'my_company_employee_ids.*' => __('attributes.negotiation.my_company_employee_ids'),
        ];
    }
}
