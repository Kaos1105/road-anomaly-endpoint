<?php

namespace App\Http\Resources\Department;

use App\Enums\Common\DateTimeEnum;
use App\Enums\Common\FavoriteFlagEnum;
use App\Helpers\DateTimeHelper;
use App\Helpers\DisplayHelper;
use App\Http\Resources\Company\CompanyRelatedResource;
use App\Http\Resources\Site\SiteRelatedResource;
use App\Models\Department;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Department
 */
class DepartmentDetailResource extends JsonResource
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
            'code' => $this->code,
            'has_favorite' => count($this->employeeFavorites) > 0 ? FavoriteFlagEnum::FAVORITE : FavoriteFlagEnum::NO_FAVORITE,
            'site' => $this->whenLoaded('site', fn() => SiteRelatedResource::make($this->site)),
            'site_id' => $this->site_id,
            'company' => $this->whenLoaded('company', fn() => CompanyRelatedResource::make($this->company)),
            'company_id' => $this->whenLoaded('company', function () {
                return $this->company->id;
            }),
            'long_name' => $this->long_name,
            'short_name' => $this->short_name,
            'kana' => $this->kana,
            'start_date' => DateTimeHelper::formatDateTime($this->start_date, DateTimeEnum::DATE_FORMAT),
            'end_date' => DateTimeHelper::formatDateTime($this->end_date, DateTimeEnum::DATE_FORMAT),
            'represent_flg' => $this->represent_flg,
            'department_classification' => $this->department_classification,
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
