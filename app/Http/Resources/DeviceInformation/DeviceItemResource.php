<?php

namespace App\Http\Resources\DeviceInformation;

use App\Enums\Common\DateTimeEnum;
use App\Helpers\DateTimeHelper;

use App\Models\DeviceInformation;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin DeviceInformation
 */
class DeviceItemResource extends JsonResource
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
            'use_classification' => $this->use_classification,
            'updated_at' => DateTimeHelper::formatDateTime($this->updated_at, DateTimeEnum::DATE_TIME_FORMAT_WO_SECOND),
        ];
    }
}
