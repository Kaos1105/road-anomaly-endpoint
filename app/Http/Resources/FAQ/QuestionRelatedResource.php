<?php

namespace App\Http\Resources\FAQ;

use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Trait\HasPermission;

/**
 * @mixin Question
 */
class QuestionRelatedResource extends JsonResource
{
    use  HasPermission;

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
            'title' => $this->title,
            'classification' => $this->classification,
        ];
    }
}
