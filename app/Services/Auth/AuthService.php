<?php

namespace App\Services\Auth;

use App\Enums\AccessPermission\Permission1FlagEnum;
use App\Enums\AuthenticationHistory\AuthenticationActionEnum;
use App\Enums\AuthenticationHistory\AuthenticationFlagEnum;
use App\Enums\Common\DateTimeEnum;
use App\Enums\Common\UseFlagEnum;
use App\Enums\System\SystemCodeEnum;
use App\Helpers\MessageHelper;
use App\Http\DTO\AccessPermission\SharedPermissionData;
use App\Http\DTO\AccessPermission\UpdatePermission1Data;
use App\Http\DTO\Auth\AuthUserData;
use App\Http\DTO\Auth\DecodeTokenData;
use App\Http\DTO\Auth\ResultPreviousLoginData;
use App\Http\DTO\Auth\ResultSendMailData;
use App\Http\DTO\Auth\TwoFactorAuthenticationMailData;
use App\Http\DTO\ResponseData;
use App\Http\Resources\Employee\EmployeePermissionResource;
use App\Mail\TwoFactorAuthenticationMail;
use App\Models\Employee;
use App\Models\Login;
use App\Models\System;
use App\Repositories\Auth\IAuthRepository;
use App\Repositories\AuthenticationHistory\IAuthenticationHistoryRepository;
use App\Repositories\Employee\IEmployeeRepository;
use App\Repositories\System\ISystemRepository;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Models\PersonalAccessToken;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;
use Laravel\Sanctum\NewAccessToken;
use Symfony\Component\HttpFoundation\Response;

class AuthService implements IAuthService
{
    public function __construct(
        public IAuthRepository                  $authRepository,
        public IEmployeeRepository              $employeeRepository,
        public ISystemRepository                $systemRepository,
        public IAuthenticationHistoryRepository $authenticationHistoryRepository,
    )
    {
    }

    public function getRepo(): IAuthRepository
    {
        return $this->authRepository;
    }

    public function clearEmployeePermission(Collection $collection): int
    {
        /**
         * @var $login Login
         */
        $login = \Auth::user();
        $employeeIds = collect([]);
        $collection->each(function (SharedPermissionData $item) use ($login, $employeeIds) {
            if ($item->employeeId !== $login->employee_id) {
                $employeeIds->push($item->employeeId);
            }
        });

        $loginIds = Login::whereIn('employee_id', $employeeIds->toArray())->pluck('id')->toArray();
        return PersonalAccessToken::query()->whereIn('tokenable_id', $loginIds)->delete();
    }

    public function clearUserToken(Collection $collection): int
    {
        /**
         * @var $login Login
         */
        $login = \Auth::user();
        $employeeIds = collect([]);
        $collection->each(function (UpdatePermission1Data $item) use ($login, $employeeIds) {
            if ($item->employeeId !== $login->employee_id || $item->permission_1 === Permission1FlagEnum::UN_AUTHORIZED_USER) {
                $employeeIds->push($item->employeeId);
            }
        });

        $loginIds = Login::whereIn('employee_id', $employeeIds->toArray())->pluck('id')->toArray();
        return PersonalAccessToken::query()->whereIn('tokenable_id', $loginIds)->delete();
    }

    public function clearAccessedToken(System $system): int
    {
        if ($system->code == SystemCodeEnum::MAIN) {
            PersonalAccessToken::truncate();
            return 0;
        }

        $loginIds = collect();
        $employees = $this->employeeRepository->getAccessedEmployee($system);

        $employees->each(function (Employee $employee) use ($loginIds) {
            if ($employee->accessHistories->count()) {
                $latestAccessHistory = $employee->accessHistories->first();
                $latestAccessAt = $latestAccessHistory?->access_at;

                $employee->logins->each(function (Login $login) use ($loginIds, $latestAccessAt) {
                    $login->personalAccessTokens->each(function (PersonalAccessToken $personalAccessToken) use ($loginIds, $latestAccessAt) {
                        if ($latestAccessAt && $personalAccessToken->created_at <= $latestAccessAt &&
                            $personalAccessToken->last_used_at >= $latestAccessAt) {
                            $loginIds->push($personalAccessToken->tokenable_id);
                        }
                    });
                });
            }
        });

        return PersonalAccessToken::query()->whereIn('tokenable_id', $loginIds->toArray())->delete();
    }

    public function isPasswordExpired(Login $login): bool
    {
        if (empty($login->password_updated_at) || Carbon::parse($login->password_updated_at)->addYear() < Carbon::now()) {
            $this->authenticationHistoryRepository->createData(
                AuthenticationActionEnum::AUTHENTICATION1_PASSWORDTIMEOUT,
                MessageHelper::getEmployeeName($login->employee) . __('message.authentication.AUTHENTICATION1_PASSWORDTIMEOUT'),
                $login->employee_id
            );
            return true;
        }
        return false;
    }

    public function handleNotImplementAuth(Login $login): ResponseData|null
    {
        if ($login->authen_flag != AuthenticationFlagEnum::IMPLEMENTED) {

            if ($login->employee->email) {
                $this->sendMailVerify($login);
                return new ResponseData(Response::HTTP_OK, new ResultSendMailData(true));
            }
            return new ResponseData(Response::HTTP_BAD_REQUEST, null);
        }
        return null;
    }

    public function checkPreviousLoginExpired(Login $login): ResponseData|null
    {
        $output = null;
        if (empty($login->previous_login_at) || Carbon::parse($login->previous_login_at)->addYear() < Carbon::now()) {
            $this->authRepository->updateLogin($login, ['authen_flag' => AuthenticationFlagEnum::NOT_IMPLEMENTED]);

            $result = $this->sendMailVerify($login);
            $output = new ResultPreviousLoginData(true, $result);
        }
        $this->authenticationHistoryRepository->createData(
            AuthenticationActionEnum::AUTHENTICATION2_OK,
            MessageHelper::getEmployeeName($login->employee) . __('message.authentication.AUTHENTICATION2_OK'),
            $login->employee_id
        );

        if ($output && $output->isExpired) {
            if ($output->isSendMail) {
                return new ResponseData(Response::HTTP_OK, $output);
            }
            return new ResponseData(Response::HTTP_BAD_REQUEST, [], trans('errors.main.2005'));
        }
        return null;
    }

    public function isUserAllowed(Employee $employee): ResponseData|null
    {
        $mainSystem = $this->systemRepository->getAuthenticatedSystem();

        if ($employee->use_classification != UseFlagEnum::USE || !$mainSystem || count($employee->accessPermissions) == 0) {
            return new ResponseData(Response::HTTP_BAD_REQUEST, [], trans('errors.service_unavailable'));
        }
        return null;
    }


    public function sendMailVerify(Login $login): bool
    {
        try {
            $employee = $login->employee;
            $now = Carbon::now()->format(DateTimeEnum::DATE_TIME_FORMAT_V2);
            $token = json_encode([
                'employee_id' => $employee->id,
                'authen_at' => $now
            ]);
            $tempToken = Crypt::encryptString($token);
            $result = Mail::to($employee->email)->sendNow(new TwoFactorAuthenticationMail(new TwoFactorAuthenticationMailData($tempToken, $employee->last_name, $employee->first_name, env('FRONTEND_URL'))));
            $this->authRepository->updateLogin($login, ['authen_at' => $now]);
            $this->authenticationHistoryRepository->createData(
                AuthenticationActionEnum::AUTHENTICATION2_IMPLEMENT,
                MessageHelper::getEmployeeName($employee) . __('message.authentication.AUTHENTICATION2_IMPLEMENT'),
                $employee->id
            );
            return true;
        } catch (Exception $exception) {
            \Log::error($exception);
            return false;
        }
    }

    public function verifyTokenTwoFactor(): AuthUserData|null
    {
        try {
            $token = request('token');
            $decodeInfo = Crypt::decryptString($token);
            $authToken = json_decode($decodeInfo);

            $authTokenInfo = DecodeTokenData::from($authToken);
            if (!$authTokenInfo->employeeId) {
                return null;
            }

            $login = $this->authRepository->findLogin($authTokenInfo->employeeId);

            if ($login->employee_id != $authTokenInfo->employeeId || $login->authen_at != $authTokenInfo->authenAt) {
                $this->authenticationHistoryRepository->createData(
                    AuthenticationActionEnum::AUTHENTICATION2_TOKENERROR,
                    MessageHelper::getEmployeeName($login->employee) . __('message.authentication.AUTHENTICATION2_TOKENERROR'),
                    $login->employee_id
                );
                return null;
            }
            if (Carbon::parse($login->authen_at)->addDay() < Carbon::now()) {
                $this->authenticationHistoryRepository->createData(
                    AuthenticationActionEnum::AUTHENTICATION2_TOKENTIMEOUT,
                    MessageHelper::getEmployeeName($login->employee) . __('message.authentication.AUTHENTICATION2_TOKENTIMEOUT'),
                    $login->employee_id
                );
                return null;
            }
            $this->authRepository->updateLogin($login, [
                'authen_flag' => AuthenticationFlagEnum::IMPLEMENTED,
                'previous_login_at' => Carbon::now()
            ]);
            $this->authenticationHistoryRepository->createData(
                AuthenticationActionEnum::AUTHENTICATION2_OK,
                MessageHelper::getEmployeeName($login->employee) . __('message.authentication.TWO_FACTOR'),
                $login->employee_id
            );
            return $this->createToken($login, request());

        } catch (Exception $exception) {
            \Log::error($exception);
            return null;
        }
    }

    public function createToken(Login $login, Request $request): AuthUserData
    {
        $login->tokens()->where('name', $request->userAgent())->delete();
        /**
         * @var $token NewAccessToken|PersonalAccessToken
         */
        $token = $login->createToken($request->userAgent());
        $employee = $this->employeeRepository->getDetail($login->employee);

        $this->authRepository->updateLogin($login, ['previous_login_at' => Carbon::now()]);
        $this->authRepository->updateInactivityExpires($login);
        return new AuthUserData($token->plainTextToken, new EmployeePermissionResource($employee));
    }
}
