<?php

namespace App\Http\Resources\Transfer;

use App\Http\Resources\Company\CompanyRelatedResource;
use App\Http\Resources\Department\DepartmentRelatedResource;
use App\Http\Resources\Division\DivisionRelatedResource;
use App\Http\Resources\Site\SiteRelatedResource;
use App\Models\Transfer;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Transfer
 */
class EmployeeSelectTransferItemResource extends JsonResource
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
            'position' => $this?->position,
            'display_order' => $this->display_order,
            'company_classification' => $this?->company?->company_classification,
            'company' => $this?->whenLoaded('company', fn() => CompanyRelatedResource::make($this->company)) ?? null,
            'site' => $this?->whenLoaded('site', fn() => SiteRelatedResource::make($this->site)),
            'department' => $this?->whenLoaded('department', fn() => DepartmentRelatedResource::make($this->department)),
            'division' => $this?->whenLoaded('division', fn() => DivisionRelatedResource::make($this->division)),
        ];
    }
}
