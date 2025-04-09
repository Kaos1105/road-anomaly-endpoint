<?php

namespace App\Http\Resources\FAQ;

use App\Enums\Common\DateTimeEnum;
use App\Helpers\DateTimeHelper;
use App\Helpers\DisplayHelper;
use App\Http\Resources\Display\DisplayRelatedResource;
use App\Models\Question;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;

/**
 * @mixin Question
 */
class QuestionDetailResource extends JsonResource
{
    protected Collection|null $permissionSimilar;

    public function setParams(Collection $permissionSimilar): self
    {
        $this->permissionSimilar = $permissionSimilar;
        return $this;
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'display' => $this->whenLoaded('display', fn() => DisplayRelatedResource::make($this->display)),
            'display_id' => $this->display_id,
            'code' => $this->code,
            'classification' => $this->classification,
            'title' => $this->title,
            'permission_2' => $this->permission_2,
            'permission_3' => $this->permission_3,
            'permission_4' => $this->permission_4,
            'similar_faq_1_id' => $this->similar_faq_1_id,
            'similar_faq_1' => $this->whenLoaded('similarFaq1', fn() => QuestionRelatedWithPermissionResource::make($this->similarFaq1)->setParams($this->permissionSimilar)),
            'similar_faq_2_id' => $this->similar_faq_2_id,
            'similar_faq_2' => $this->whenLoaded('similarFaq2', fn() => QuestionRelatedWithPermissionResource::make($this->similarFaq2)->setParams($this->permissionSimilar)),
            'similar_faq_3_id' => $this->similar_faq_3_id,
            'similar_faq_3' => $this->whenLoaded('similarFaq3', fn() => QuestionRelatedWithPermissionResource::make($this->similarFaq3)->setParams($this->permissionSimilar)),
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
