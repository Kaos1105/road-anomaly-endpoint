<?php

namespace App\Http\Requests\Favorite;

use App\Enums\Common\DateTimeEnum;
use App\Enums\Common\FavoriteTypeEnum;
use App\Models\Login;
use Auth;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreFavoriteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        /**
         * @var $login Login
         */
        $login = \Auth::user();
        $this->merge([
            'employee_id' => $login->employee_id,
            'updated_by' => $login->employee_id,
            'updated_at' =>  Carbon::now()->format(DateTimeEnum::DATE_TIME_FORMAT_V2),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'favorable_type' => ['required', 'string', Rule::in(FavoriteTypeEnum::getValues())],
            'favorable_id' => ['required', 'numeric'],
            'employee_id' => ['required', 'numeric'],
            'updated_by' => ['numeric', 'nullable'],
            'updated_at' => ['string', 'nullable'],
        ];
    }

    public function attributes(): array
    {
        return [
            'favorable_type' => __('attributes.favorite.favorable_type'),
            'favorable_id' => __('attributes.favorite.favorable_id'),
            'employee_id' => __('attributes.favorite.employee_id'),
            'updated_by' => __('attributes.common.updated_by'),
            'updated_at' => __('attributes.common.updated_at')
        ];
    }
}
