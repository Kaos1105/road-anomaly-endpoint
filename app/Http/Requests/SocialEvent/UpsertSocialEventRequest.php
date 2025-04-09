<?php

namespace App\Http\Requests\SocialEvent;

use App\Enums\Common\UseFlagEnum;
use App\Enums\SocialEvent\EventProgressClassificationEnum;
use App\Http\Requests\TimestampRequest;
use App\Models\EventClassification;
use App\Models\SocialEvent;
use App\Models\ManagementGroup;
use Illuminate\Validation\Rule;

class UpsertSocialEventRequest extends TimestampRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        parent::prepareForValidation();
        $isNotUse = $this->input('event_progress') == EventProgressClassificationEnum::IN_PREPARATION;

        $this->merge([
            'use_classification' => $isNotUse ? UseFlagEnum::NOT_USE : $this->input('use_classification'),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        /**
         * @var SocialEvent $socialEvent
         */
        $socialEvent = request('social_event');
        $managementGroupIds = ManagementGroup::query()->get()->pluck('id')->toArray();
        $eventClassificationIds = EventClassification::query()->get()->pluck('id')->toArray();

        if (!$socialEvent) {
            return [
                ...parent::rules(),
                'group_id' => ['required', 'numeric', Rule::in($managementGroupIds)],
                'event_id' => ['required', 'numeric', Rule::in($eventClassificationIds)],
                'event_title' => 'required|string|max:100|unique:social_social_events,event_title',
                'event_progress' => ['required', 'numeric', Rule::in(EventProgressClassificationEnum::getValues())],
                'planned_start' => 'required|date',
                'creation_deadline' => 'required|date',
                'approval_deadline' => 'required|date',
                'order_deadline' => 'required|date',
                'planned_completion' => 'required|date',
                'plan_comment' => 'nullable|string',
                'memo' => 'nullable|string',
                'use_classification' => ['required', 'numeric', Rule::in(UseFlagEnum::getValues())],
            ];
        }

        return $this->updateRules($socialEvent);
    }

    public function updateRules(SocialEvent $socialEvent): array
    {
        return [
            ...parent::rules(),
            'event_title' => ['required', 'string', 'max:100', Rule::unique('social_social_events', 'event_title')->ignore($socialEvent->id)],
            'event_progress' => ['required', 'numeric', Rule::in(EventProgressClassificationEnum::getValues())],
            'planned_start' => 'required|date',
            'creation_deadline' => 'required|date',
            'approval_deadline' => 'required|date',
            'order_deadline' => 'required|date',
            'planned_completion' => 'required|date',
            'plan_comment' => 'nullable|string',
            'actual_comment' => 'nullable|string',
            'memo' => 'nullable|string',
            'use_classification' => ['required', 'numeric', Rule::in(UseFlagEnum::getValues())],
        ];
    }

    public function attributes(): array
    {
        return [
            'group_id' => __('attributes.social_event.group_id'),
            'event_id' => __('attributes.social_event.event_id'),
            'event_title' => __('attributes.social_event.event_title'),
            'event_progress' => __('attributes.social_event.event_progress'),
            'planned_start' => __('attributes.social_event.planned_start'),
            'creation_deadline' => __('attributes.social_event.creation_deadline'),
            'approval_deadline' => __('attributes.social_event.approval_deadline'),
            'order_deadline' => __('attributes.social_event.order_deadline'),
            'planned_completion' => __('attributes.social_event.planned_completion'),
            'plan_comment' => __('attributes.social_event.plan_comment'),
            'actual_comment' => __('attributes.social_event.actual_comment'),
            'memo' => __('attributes.common.note'),
            'use_classification' => __('attributes.common.use_classification'),
            'display_order' => __('attributes.common.display_order'),
        ];
    }
}
