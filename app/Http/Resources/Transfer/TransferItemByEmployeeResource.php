<?php

namespace App\Http\Resources\Transfer;

use App\Enums\Common\DateTimeEnum;
use App\Helpers\DateTimeHelper;
use App\Http\Resources\Company\CompanyRelatedResource;
use App\Http\Resources\Department\DepartmentRelatedResource;
use App\Http\Resources\Division\DivisionRelatedResource;
use App\Http\Resources\Site\SiteRelatedResource;
use App\Models\Transfer;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Transfer
 */
class TransferItemByEmployeeResource extends JsonResource
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
            'employee_id' => $this->employee_id,
            'start_date' => DateTimeHelper::formatDateTime($this->start_date, DateTimeEnum::DATE_FORMAT),
            'end_date' => DateTimeHelper::formatDateTime($this->end_date, DateTimeEnum::DATE_FORMAT),
            'position' => $this->position,
            'major_history_flg' => $this->major_history_flg,
            'display_order' => $this->display_order,
            'updated_at' => DateTimeHelper::formatDateTime($this->updated_at, DateTimeEnum::DATE_FORMAT),
            'company' => $this->whenLoaded('company', fn() => CompanyRelatedResource::make($this->company)),
            'site' => $this->whenLoaded('site', fn() => SiteRelatedResource::make($this->site)),
            'department' => $this->whenLoaded('department', fn() => DepartmentRelatedResource::make($this->department)),
            'division' => $this->whenLoaded('division', fn() => DivisionRelatedResource::make($this->division)),
        ];
    }
}
