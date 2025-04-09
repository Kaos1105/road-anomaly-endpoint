<?php

namespace App\Http\Requests\User;

use App\Models\User;
use Auth;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpsertUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        /**
         * @var $user User
         */
        $user = request('user');
        if (! $user) {
            return [
                'login_id' => 'required|string|max:255|unique:users,login_id',
                'name' => 'required|string|max:255',
                'password' => 'required|string|min:8',
                'email' => 'email|unique:users,email|max:255|nullable',
            ];
        }

        return $this->updateRules($user);
    }

    public function updateRules(User $user): array
    {
        return [
            'name' => 'nullable|string|max:255',
            'password' => 'nullable|string|min:8',
            'login_id' => ['nullable', 'string', 'max:255',  Rule::unique('users', 'login_id')->ignore($user->id)],
            'email' => ['email', 'max:255', 'nullable',
                Rule::unique('users', 'email')->ignore($user->id)],
        ];
    }
}
