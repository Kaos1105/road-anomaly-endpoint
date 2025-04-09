<?php

namespace App\Http\Requests\Layout;

use App\Enums\Layout\LayoutBlockEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LayoutDragDropRequest extends FormRequest
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
        return [
            'blockA' => ['nullable', 'array'],
            'blockA.*.id' => ['required', Rule::exists('common_layouts', 'id')],
            'blockA.*.system_id' => ['required', Rule::exists('snet_systems', 'id')],
            'blockA.*.content_no' => ['required'],
            'blockA.*.block' => ['required', 'string', Rule::in(LayoutBlockEnum::getValues())],
            'blockA.*.block_order' => 'required|numeric',

            'blockB' => ['nullable', 'array'],
            'blockB.*.id' => ['required', Rule::exists('common_layouts', 'id')],
            'blockB.*.system_id' => ['required', Rule::exists('snet_systems', 'id')],
            'blockB.*.content_no' => ['required'],
            'blockB.*.block' => ['required', 'string', Rule::in(LayoutBlockEnum::getValues())],
            'blockB.*.block_order' => 'required|numeric',

            'blockC' => ['nullable', 'array'],
            'blockC.*.id' => ['required', Rule::exists('common_layouts', 'id')],
            'blockC.*.system_id' => ['required', Rule::exists('snet_systems', 'id')],
            'blockC.*.content_no' => ['required'],
            'blockC.*.block' => ['required', 'string', Rule::in(LayoutBlockEnum::getValues())],
            'blockC.*.block_order' => 'required|numeric',
        ];
    }

    public function attributes(): array
    {
        return [
            'blockA' => __('attributes.layout.block'),
            'blockB' => __('attributes.layout.block'),
            'blockC' => __('attributes.layout.block'),
            'blockA.*.id' => __('attributes.layout.id'),
            'blockB.*.id' => __('attributes.layout.id'),
            'blockC.*.id' => __('attributes.layout.id'),
            'blockA.*.system_id' => __('attributes.layout.system_id'),
            'blockB.*.system_id' => __('attributes.layout.system_id'),
            'blockC.*.system_id' => __('attributes.layout.system_id'),
            'blockA.*.content_no' => __('attributes.layout.content_no'),
            'blockB.*.content_no' => __('attributes.layout.content_no'),
            'blockC.*.content_no' => __('attributes.layout.content_no'),
            'blockA.*.block' => __('attributes.layout.block'),
            'blockB.*.block' => __('attributes.layout.block'),
            'blockC.*.block' => __('attributes.layout.block'),
            'blockA.*.block_order' => __('attributes.layout.block_order'),
            'blockB.*.block_order' => __('attributes.layout.block_order'),
            'blockC.*.block_order' => __('attributes.layout.block_order'),
        ];
    }
}
