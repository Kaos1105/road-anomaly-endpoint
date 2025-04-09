<?php

namespace App\Http\Requests\DeviceInformation;

use App\Enums\Common\DateTimeEnum;
use App\Models\Login;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateDeviceTokenRequest extends FormRequest
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
        /*** @var $login Login
         */
        $login = \Auth::user();
        $now = Carbon::now()->format(DateTimeEnum::DATE_TIME_FORMAT_V2);

        $this->merge([
            'updated_at' => $now,
            'updated_by' => $login->employee_id,
            'employee_id' => $login->employee_id
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
            'name' => ['required', 'string', 'max:100', Rule::exists('main_device_informations', 'name')],
            'device_token' => ['required', 'max:200'],
            'employee_id' => ['nullable'],

        ];

    }

    public function attributes(): array
    {
        return [
            'name' => __('attributes.device.name'),
            'device_token' => __('attributes.device.device_token'),
            'employee_id' => __('attributes.device.employee_id'),
        ];
    }
}
