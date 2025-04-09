<?php

namespace App\Http\Resources\Transfer;

use App\Enums\Common\DateTimeEnum;
use App\Helpers\DateTimeHelper;
use App\Http\Resources\Employee\EmployeeRelatedResource;
use App\Models\Transfer;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Transfer
 */
class TransferCopyDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'employee' => $this->whenLoaded('employee', fn() => EmployeeRelatedResource::make($this->employee)),
            'company_id' => $this->company_id,
            'site_id' => $this->site_id,
            'department_id' => $this->department_id,
            'division_id' => $this->division_id,
            'team_name' => $this->team_name,
            'position' => $this->position,
            'start_date' => DateTimeHelper::formatDateTime($this->start_date, DateTimeEnum::DATE_FORMAT),
            'end_date' => DateTimeHelper::formatDateTime($this->end_date, DateTimeEnum::DATE_FORMAT),
            'contract_classification' => $this->contract_classification,
            'transfer_classification' => $this->transfer_classification,
            'display_order' => $this->display_order,
        ];
    }
}
