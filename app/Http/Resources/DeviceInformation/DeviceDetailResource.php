<?php

namespace App\Http\Resources\DeviceInformation;

use App\Enums\Common\DateTimeEnum;
use App\Helpers\DateTimeHelper;

use App\Helpers\DisplayHelper;
use App\Models\DeviceInformation;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin DeviceInformation
 */
class DeviceDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'device_information' => $this->device_information,
            'device_token' => $this->device_token,
            'use_classification' => $this->use_classification,
            'created_info' => $this->whenLoaded('createdBy', fn() => [
                'date' => DateTimeHelper::formatDateTime($this->created_at, DateTimeEnum::DATE_TIME_FORMAT),
                'name' => DisplayHelper::formatEmployeeName($this->createdBy),
            ]),
            'updated_info' => $this->whenLoaded('updatedBy', fn() => [
                'date' => DateTimeHelper::formatDateTime($this->updated_at, DateTimeEnum::DATE_TIME_FORMAT),
                'name' => DisplayHelper::formatEmployeeName($this->updatedBy),
            ]),
        ];
    }
}

