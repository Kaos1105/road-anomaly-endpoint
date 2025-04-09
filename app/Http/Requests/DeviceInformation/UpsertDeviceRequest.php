<?php

namespace App\Http\Requests\DeviceInformation;

use App\Enums\Common\UseFlagEnum;
use App\Http\Requests\TimestampRequest;
use App\Models\DeviceInformation;

use Illuminate\Validation\Rule;

class UpsertDeviceRequest extends TimestampRequest
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
        /**
         * @var $device DeviceInformation
         */
        $device = request('device');
        $mergeData = ['employee_id' => \Auth::user()->employee_id];
        if (empty($device)) {
            $mergeData['device_information'] = $this->header('user-agent');
        }
        $this->merge($mergeData);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        /**
         * @var $device DeviceInformation
         */
        $device = request('device');
        $nameRule = $device ? ['nullable'] : ['required'];
        return [
            ...parent::rules(),
            'name' => [...$nameRule, 'string', 'max:100', Rule::unique('main_device_informations', 'name')->ignore($device?->id)],
            'device_information' => ['nullable', 'string', 'max:200'],
            'device_token' => ['nullable', 'max:200'],
            'employee_id' => ['nullable'],
            'use_classification' => Rule::in(UseFlagEnum::getValues()),
        ];

    }

    public function attributes(): array
    {
        return [
            'name' => __('attributes.device.name'),
            'device_information' => __('attributes.device.device_information'),
            'device_token' => __('attributes.device.device_token'),
            'employee_id' => __('attributes.device.employee_id'),
            'use_classification' => __('attributes.device.use_classification'),
        ];
    }
}
