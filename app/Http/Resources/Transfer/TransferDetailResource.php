<?php

namespace App\Http\Resources\Transfer;

use App\Enums\Common\DateTimeEnum;
use App\Helpers\DateTimeHelper;
use App\Helpers\DisplayHelper;
use App\Http\Resources\Company\CompanyRelatedResource;
use App\Http\Resources\Department\DepartmentRelatedResource;
use App\Http\Resources\Division\DivisionRelatedResource;
use App\Http\Resources\Employee\EmployeeRelatedResource;
use App\Http\Resources\Site\SiteRelatedResource;
use App\Models\Transfer;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Transfer
 */
class TransferDetailResource extends JsonResource
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
            'company' => $this->whenLoaded('company', fn() => CompanyRelatedResource::make($this->company)),
            'site' => $this->whenLoaded('site', fn() => SiteRelatedResource::make($this->site)),
            'department' => $this->whenLoaded('department', fn() => DepartmentRelatedResource::make($this->department)),
            'division' => $this->whenLoaded('division', fn() => DivisionRelatedResource::make($this->division)),
            'represent_flg' => $this->represent_flg,
            'team_name' => $this->team_name,
            'position' => $this->position,
            'start_date' => DateTimeHelper::formatDateTime($this->start_date, DateTimeEnum::DATE_FORMAT),
            'end_date' => DateTimeHelper::formatDateTime($this->end_date, DateTimeEnum::DATE_FORMAT),
            'contract_classification' => $this->contract_classification,
            'major_history_flg' => $this->major_history_flg,
            'transfer_classification' => $this->transfer_classification,
            'memo' => $this->memo,
            'display_order' => $this->display_order,
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
