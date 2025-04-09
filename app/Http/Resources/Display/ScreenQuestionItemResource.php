<?php

namespace App\Http\Resources\Display;

use App\Http\Resources\FAQ\QuestionHelpItemResource;
use App\Models\Display;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Display
 */
class ScreenQuestionItemResource extends JsonResource
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
            'system_id' => $this->system_id,
            'name' => $this->name,
            'number_of_question' => count($this->questions),
            'questions' => $this->whenLoaded('questions', fn() => QuestionHelpItemResource::collection($this->questions)),
        ];
    }
}
