<?php

namespace App\Rules;

use App\Models\Content;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ContentNoUniqueRule implements ValidationRule
{
    public int $displayId;

    public function __construct($displayId)
    {
        $this->displayId = $displayId;

    }

    /**
     * Run the validation rule.
     *
     * @param \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        //
        $contentNos = Content::where('display_id', $this->displayId)->get()->pluck('no');
        if ($contentNos->contains($value)) {
            $fail(__('validation.existed', ['attribute' => __('attributes.content.no')]));
        }
    }
}
