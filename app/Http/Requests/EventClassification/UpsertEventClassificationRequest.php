<?php

namespace App\Http\Requests\EventClassification;

use App\Enums\Common\DisplayOrderEnum;
use App\Enums\Common\UseFlagEnum;
use App\Http\Requests\TimestampRequest;
use App\Models\EventClassification;
use Illuminate\Validation\Rule;

class UpsertEventClassificationRequest extends TimestampRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        /**
         * @var EventClassification $eventClassification
         */
        $eventClassification = request('event_classification');
        if (!$eventClassification) {
            return [
                ...parent::rules(),
                'name' => 'required|string|max:20|unique:social_event_classifications,name',
                'description' => 'string|nullable',
                'operation_rule' => 'string|nullable',
                'social_criteria' => 'string|nullable',
                'memo' => 'string|nullable',
                'use_classification' => ['required', 'numeric', Rule::in(UseFlagEnum::getValues())],
                'display_order' => ['required', 'numeric', 'min:0', 'max:' . DisplayOrderEnum::DEFAULT],
            ];
        }

        return $this->updateRules($eventClassification);
    }

    public function updateRules(EventClassification $eventClassification): array
    {
        return [
            ...parent::rules(),
            'name' => ['required', 'string', 'max:20', Rule::unique('social_event_classifications', 'name')->ignore($eventClassification->id)],
            'description' => 'string|nullable',
            'operation_rule' => 'string|nullable',
            'social_criteria' => 'string|nullable',
            'memo' => 'string|nullable',
            'use_classification' => ['required', 'numeric', Rule::in(UseFlagEnum::getValues())],
            'display_order' => ['required', 'numeric', 'min:0', 'max:' . DisplayOrderEnum::DEFAULT],
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => __('attributes.event_classification.name'),
            'description' => __('attributes.event_classification.name'),
            'operation_rule' => __('attributes.event_classification.name'),
            'social_criteria' => __('attributes.event_classification.name'),
            'memo' => __('attributes.common.note'),
            'use_classification' => __('attributes.common.use_classification'),
            'display_order' => __('attributes.common.display_order'),
        ];
    }
}
