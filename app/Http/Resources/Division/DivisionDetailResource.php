<?php

namespace App\Http\Resources\Division;

use App\Enums\Common\DateTimeEnum;
use App\Enums\Common\FavoriteFlagEnum;
use App\Helpers\DateTimeHelper;
use App\Helpers\DisplayHelper;
use App\Http\Resources\Company\CompanyRelatedResource;
use App\Http\Resources\Department\DepartmentRelatedResource;
use App\Http\Resources\Site\SiteRelatedResource;
use App\Models\Division;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Division
 */
class DivisionDetailResource extends JsonResource
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
            'has_favorite' => count($this->employeeFavorites) > 0 ? FavoriteFlagEnum::FAVORITE : FavoriteFlagEnum::NO_FAVORITE,
            'code' => $this->code,
            'department_id' => $this->department_id,
            'company' => $this->whenLoaded('department', fn() => CompanyRelatedResource::make($this->department->site->company)),
            'site' => $this->whenLoaded('department', fn() => SiteRelatedResource::make($this->department->site)),
            'department' => $this->whenLoaded('department', fn() => DepartmentRelatedResource::make($this->department)),
            'long_name' => $this->long_name,
            'short_name' => $this->short_name,
            'kana' => $this->kana,
            'start_date' => DateTimeHelper::formatDateTime($this->start_date, DateTimeEnum::DATE_FORMAT),
            'end_date' => DateTimeHelper::formatDateTime($this->end_date, DateTimeEnum::DATE_FORMAT),
            'represent_flg' => $this->represent_flg,
            'division_classification' => $this->division_classification,
            'previous_name' => $this->previous_name,
            'previous_name_flg' => $this->previous_name_flg,
            'en_notation' => $this->en_notation,
            'phone' => $this->phone,
            'memo' => $this->memo,
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
