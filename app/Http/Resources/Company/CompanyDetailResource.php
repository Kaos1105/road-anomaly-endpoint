<?php

namespace App\Http\Resources\Company;

use App\Enums\Common\DateTimeEnum;
use App\Enums\Common\FavoriteFlagEnum;
use App\Helpers\DateTimeHelper;
use App\Helpers\DisplayHelper;
use App\Models\Company;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Company
 * @property int count_favorites
 */
class CompanyDetailResource extends JsonResource
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
            'long_name' => $this->long_name,
            'short_name' => $this->short_name,
            'kana' => $this->kana,
            'start_date' => DateTimeHelper::formatDateTime($this->start_date, DateTimeEnum::DATE_FORMAT),
            'end_date' => DateTimeHelper::formatDateTime($this->end_date, DateTimeEnum::DATE_FORMAT),
            'company_classification' => $this->company_classification,
            'group_name' => $this->group_name,
            'previous_name' => $this->previous_name,
            'previous_name_flg' => $this->previous_name_flg,
            'en_notation' => $this->en_notation,
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
