<?php

namespace App\Http\Resources\Individual;

use App\Enums\Common\DateTimeEnum;
use App\Helpers\DateTimeHelper;
use App\Helpers\DisplayHelper;
use App\Models\IndividualContract;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin IndividualContract
 */
class IndividualContractItemResource extends JsonResource
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
            'start_date' => DateTimeHelper::formatDateTime($this->start_date, DateTimeEnum::DATE_FORMAT),
            'end_date' => DateTimeHelper::formatDateTime($this->end_date, DateTimeEnum::DATE_FORMAT),
            'name' => $this->name,
            'unit_price' => $this->unit_price,
            'unit_classification' => $this->unit_classification,
            'unit_name' => $this->unit_name,
            'rounding_method' => $this->rounding_method,
            'display_order' => $this->display_order,
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
