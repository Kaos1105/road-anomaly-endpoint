<?php

namespace App\Http\Resources\Transfer;

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
class SocialDataTransferResource extends JsonResource
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
            'position' => $this->position,
            'display_order' => $this->display_order,
            'employee' => $this->whenLoaded('employee', fn() => EmployeeRelatedResource::make($this->employee)),
            'company' => $this->whenLoaded('company', fn() => CompanyRelatedResource::make($this->company)),
            'site' => $this->whenLoaded('site', fn() => SiteRelatedResource::make($this->site)),
            'department' => $this->whenLoaded('department', fn() => DepartmentRelatedResource::make($this->department)),
            'division' => $this->whenLoaded('division', fn() => DivisionRelatedResource::make($this->division)),
        ];
    }
}
