<?php

namespace App\Http\Requests\Announcement;

use App\Enums\Announcement\AnnouncementClassificationEnum;
use App\Enums\Common\UseFlagEnum;
use App\Http\Requests\TimestampRequest;
use Illuminate\Validation\Rule;

class UpsertAnnouncementRequest extends TimestampRequest
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
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            ...parent::rules(),
            'system_id' => ['numeric', 'required', Rule::exists('snet_systems', 'id')],
            'display_id' => ['numeric', 'nullable', Rule::exists('snet_displays', 'id')],
            'announcement_classification' => ['required', 'numeric', Rule::in(AnnouncementClassificationEnum::getValues())],
            'title' => 'required|string|min:1|max:100',
            'content' => 'nullable|string',
            'start_time' => 'date|required',
            'end_time' => 'date|nullable|after_or_equal:start_time',
            'use_classification' => ['required', 'numeric', Rule::in(UseFlagEnum::getValues())],
        ];
    }

    public function attributes(): array
    {
        return [
            'system_id' => __('attributes.announcement.display_id'),
            'display_id' => __('attributes.announcement.display_id'),
            'announcement_classification' => __('attributes.announcement.announcement_classification'),
            'title' => __('attributes.announcement.title'),
            'content' => __('attributes.announcement.content'),
            'start_time' => __('attributes.announcement.start_time'),
            'end_time' => __('attributes.announcement.end_time'),
            'use_classification' => __('attributes.common.use_classification'),
        ];
    }
}
