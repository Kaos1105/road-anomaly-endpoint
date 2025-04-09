<?php

namespace App\Http\Requests\Auth;

use App\Enums\Common\LockCountEnum;
use App\Helpers\MessageHelper;
use App\Http\DTO\ResponseData;
use App\Models\AuthenticationHistory;
use App\Models\Login;
use App\Trait\HandleResponse;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    use HandleResponse;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'login_id' => trans('attributes.login_id'),
            'password' => trans('attributes.password'),
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'login_id' => 'required',
            'password' => 'required',
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            if ($this->has('login_id') || $this->has('password')) {
                if ($validator->errors()->has('login_id') || $validator->errors()->has('password')) {
                    $validator->errors()->forget('login_id');
                    $validator->errors()->forget('password');
                    $validator->errors()->add('login_id', __('errors.login_id_invalid'));
                    $validator->errors()->add('password', __('errors.login_id_invalid'));
                }
            }
        });
    }

    /**
     * @throws ValidationException
     */
    public function authenticate(): ?ResponseData
    {
        $key = $this->throttleKey();
        if ($rateLimited = $this->ensureIsNotRateLimited()) {
            return $rateLimited;
        }

        $accountLogin = Login::where('login_id', $this->only('login_id'))->first();
        if (!$accountLogin) {
            AuthenticationHistory::insert([
                'action' => 'AUTHENTICATION1_IDERROR',
                'message' => __('message.authentication.AUTHENTICATION1_IDERROR'),
                'authen_at' => Carbon::now()
            ]);
            RateLimiter::hit($key);
            if (RateLimiter::tooManyAttempts($key, LockCountEnum::MAX_ATTEMPT_COUNT)) {
                RateLimiter::hit($this->throttleLockKey(), LockCountEnum::DECAY_RATE_MINUTE * 60);
                RateLimiter::clear($key);
                return $this->ensureIsNotRateLimited();
            }

            return $this->httpBadRequest([], trans('errors.login_id_invalid'));
        }

        if (!Auth::attempt($this->only('login_id', 'password'))) {
            AuthenticationHistory::insert([
                'employee_id' => $accountLogin->employee_id,
                'action' => 'AUTHENTICATION1_PASSWORDERROR',
                'message' => MessageHelper::getEmployeeName($accountLogin->employee) . __('message.authentication.AUTHENTICATION1_PASSWORDERROR'),
                'authen_at' => Carbon::now()
            ]);

            RateLimiter::hit($key);
            if (RateLimiter::tooManyAttempts($key, LockCountEnum::MAX_ATTEMPT_COUNT)) {
                RateLimiter::hit($this->throttleLockKey(), LockCountEnum::DECAY_RATE_MINUTE * 60);
                RateLimiter::clear($key);
                return $this->ensureIsNotRateLimited();
            }

            return $this->httpBadRequest([], trans('errors.login_id_invalid'));
        }

        RateLimiter::clear($key);
        RateLimiter::clear($this->throttleLockKey());
        return null;
    }

    public function ensureIsNotRateLimited(): ?ResponseData
    {
        $seconds = RateLimiter::availableIn($this->throttleLockKey());

        if ($seconds > 0) {
            return $this->httpRateLimit(errors: [
                'login_id' => trans('errors.login_id_invalid'),
                'locked_seconds' => $seconds,
            ]);
        }

        return null;
    }

    /**
     * Get the rate limiting throttle key for the request.
     */
    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->input('login_id')) . '|' . $this->ip());
    }

    public function throttleLockKey(): string
    {
        return "{$this->throttleKey()}_lock";
    }

}
