<?php

namespace App\Http\Resources\System;

use App\Enums\Common\DateTimeEnum;
use App\Helpers\DateTimeHelper;
use App\Models\System;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin System
 * @property int operation_classification
 */
class SystemRelationResource extends JsonResource
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
            'code' => $this->code,
            'name' => $this->name,
            'operation_classification' => $this->operation_classification,
            'start_date' => DateTimeHelper::formatDateTime($this->start_date, DateTimeEnum::DATE_FORMAT),
            'end_date' => DateTimeHelper::formatDateTime($this->end_date, DateTimeEnum::DATE_FORMAT),
            'use_classification' => $this->use_classification,
            'display_order' => $this->display_order,
        ];
    }
}
