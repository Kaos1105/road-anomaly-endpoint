<?php

namespace App\Http\Requests\Contract;

use App\Enums\Contract\PresidentApprovalStatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class ApproveBasicContractRequest extends FormRequest
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
        return ['approval_flag' => Rule::in(PresidentApprovalStatusEnum::getValues())];
    }

    public function attributes(): array
    {
        return ['approval_flag' => __('attributes.basic_contract.approval_flg')];
    }

}
