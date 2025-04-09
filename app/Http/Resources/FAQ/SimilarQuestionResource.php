<?php

namespace App\Http\Resources\FAQ;

use App\Enums\FAQ\SimilarQuestionTitleEnum;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

/**
 * @mixin Question
 */
class SimilarQuestionResource extends JsonResource
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
        ];
    }
}
