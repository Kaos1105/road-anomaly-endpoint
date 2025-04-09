<?php

namespace App\Http\Requests\Negotiation;

use App\Enums\Common\DateTimeEnum;
use App\Models\Login;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class CommentNegotiationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {

        return true;
    }

    protected function prepareForValidation(): void
    {
        /*** @var $login Login
         */
        $login = \Auth::user();

        $now = Carbon::now()->format(DateTimeEnum::DATE_TIME_FORMAT_V2);
        parent::prepareForValidation();
        $this->merge([
            'manager_comment_at' => $now,
            'manager_comment_by' => $login->employee_id,
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'manager_comment_at' => ['string', 'nullable'],
            'manager_comment_by' => ['numeric', 'nullable'],
            'manager_comment' => ['string', 'nullable'],
        ];
    }

    public function attributes(): array
    {
        return [
            'manager_comment' => __('attributes.negotiation.manager_comment'),
        ];
    }
}
