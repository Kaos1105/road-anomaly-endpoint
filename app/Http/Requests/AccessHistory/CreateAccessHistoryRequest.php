<?php

namespace App\Http\Requests\AccessHistory;

use App\Enums\AccessHistory\AccessActionTypeEnum;
use App\Enums\AccessHistory\AccessibleTypeEnum;
use App\Enums\AccessHistory\ResultClassificationEnum;
use App\Enums\Common\DateTimeEnum;
use App\Models\Login;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateAccessHistoryRequest extends FormRequest
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
         * @var $login Login
         */
        $login = \Auth::user();
        $this->merge([
            'result_classification' => $this->input('result_classification') ?? ResultClassificationEnum::OK,
            'message' => $this->input('message'),
            'employee_id' => $login->employee_id,
            'access_at' => Carbon::now()->format(DateTimeEnum::DATE_TIME_FORMAT_V2),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'system_id' => ['required', 'numeric', Rule::exists('snet_systems', 'id')],
            'employee_id' => ['required', 'numeric'],
            'accessible_type' => ['nullable', 'string', Rule::in(AccessibleTypeEnum::getValues())],
            'accessible_id' => ['nullable', 'numeric'],
            'action' => ['required', 'string', 'max:50', Rule::in(AccessActionTypeEnum::getValues())],
            'result_classification' => ['required', 'string', 'max:50', Rule::in(ResultClassificationEnum::getValues())],
            'message' => ['nullable', 'string', 'max:200'],
            'access_at' => ['string', 'nullable'],
        ];
    }

    public function attributes(): array
    {
        return [
            'system_id' => __('attributes.access_history.system_id'),
            'accessible_type' => __('attributes.access_history.accessible_type'),
            'accessible_id' => __('attributes.access_history.accessible_id'),
            'action' => __('attributes.access_history.action'),
            'result_classification' => __('attributes.access_history.result_classification'),
            'message' => __('attributes.access_history.message')
        ];
    }
}
