<?php

namespace App\Http\Resources\FAQ;

use App\Enums\Common\DateTimeEnum;
use App\Helpers\DateTimeHelper;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Question
 */
class QuestionItemResource extends JsonResource
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
            'code' => $this->code,
            'classification' => $this->classification,
            'title' => $this->title,
            'similar_faq_1' => $this->whenLoaded('similarFaq1', fn() => QuestionRelatedResource::make($this->similarFaq1)),
            'similar_faq_2' => $this->whenLoaded('similarFaq2', fn() => QuestionRelatedResource::make($this->similarFaq2)),
            'similar_faq_3' => $this->whenLoaded('similarFaq3', fn() => QuestionRelatedResource::make($this->similarFaq3)),
            'display_order' => $this->display_order,
            'use_classification' => $this->use_classification,
            'updated_at' => DateTimeHelper::formatDateTime($this->updated_at, DateTimeEnum::DATE_FORMAT),
        ];
    }
}
