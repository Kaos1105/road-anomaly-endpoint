<?php

namespace App\Http\Controllers\Auth;

use App\Enums\AuthenticationHistory\AuthenticationActionEnum;
use App\Helpers\MessageHelper;
use App\Http\Controllers\Controller;
use App\Http\DTO\Auth\AuthUserData;
use App\Http\DTO\Auth\LoginData;
use App\Http\DTO\ResponseData;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterLoginRequest;
use App\Http\Requests\Auth\UpsertLoginRequest;
use App\Http\Resources\Employee\EmployeePermissionResource;
use App\Http\Resources\Login\LoginResource;
use App\Models\Login;
use App\Services\Auth\IAuthService;
use App\Services\AuthenticationHistory\IAuthenticationHistoryService;
use App\Services\Employee\IEmployeeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function __construct(
        private readonly IAuthService                  $authService,
        private readonly IEmployeeService              $employeeService,
        private readonly IAuthenticationHistoryService $authenticationHistoryService,
    )
    {
    }

    public function store(UpsertLoginRequest $request): ResponseData
    {
        $data = $request->validated();
        $login = $this->authService->getRepo()->create($data);

        return $this->httpCreated(new LoginResource($login));
    }

    public function update(UpsertLoginRequest $request, Login $login): ResponseData
    {
        $data = $request->validated();
        $login = $this->authService->getRepo()->update($data, $login->id);

        return $this->httpNoContent();
    }

    public function massUpdate(): ResponseData
    {
//        $logins = Login::where('id', '>', 0)->skip(600)->take(100)->get();
//        $loginResult = collect([]);
//
//        foreach ($logins as $login) {
//            $loginResult->push([
//                ...$login->toArray(),
//                'password' => Hash::make($login->login_id),
//                'password_decrypt' => $login->login_id,
//                'created_at' => $login->created_at,
//                'updated_at' => $login->updated_at,
//            ]);
//        }
//        Login::upsert($loginResult->toArray(), uniqueBy: ['id']);

        return $this->httpOk();
    }

    public function register(RegisterLoginRequest $request): ResponseData
    {
        $data = $request->validated();

        $user = $this->authService->getRepo()->create($data);
        $login = $this->authService->getRepo()->showWithRelationship($user);

        $token = $user->createToken('auth_token')->plainTextToken;

        return $this->httpCreated(new AuthUserData($token, new EmployeePermissionResource($login->employee)));
    }

    public function login(LoginRequest $request): ResponseData
    {
        $attempted = $request->authenticate();
        if ($attempted) {
            return $attempted;
        }
        $loginData = LoginData::from($request->validated());

        $login = $this->authService->getRepo()->getUserLogin($loginData);

        if ($this->authService->isPasswordExpired($login)) {
            return $this->httpBadRequest([], trans('errors.main.2004'));
        }

        $this->authenticationHistoryService->getRepo()->createData(
            AuthenticationActionEnum::AUTHENTICATION1_OK,
            MessageHelper::getEmployeeName($login->employee) . __('message.authentication.AUTHENTICATION1_OK'),
            $login->employee_id
        );

        $handleNotImplementAuth = $this->authService->handleNotImplementAuth($login);
        if ($handleNotImplementAuth) {
            return $handleNotImplementAuth;
        }

        $previousLoginResult = $this->authService->checkPreviousLoginExpired($login);
        if ($previousLoginResult) {
            return $previousLoginResult;
        }

        $userAccessResult = $this->authService->isUserAllowed($login->employee);
        if ($userAccessResult) {
            return $userAccessResult;
        }

        $result = $this->authService->createToken($login, $request);
        return $this->httpOk($result);
    }

    public function logout(Request $request): ResponseData
    {
        $request->user()->currentAccessToken()->delete();

        return $this->httpOk(null, __('message.token_revoked'));
    }

    public function profile(): ResponseData
    {
        /**
         * @var $login Login
         */
        $login = Auth::user();
        $employee = $this->employeeService->getRepo()->getDetail($login->employee);

        return $this->httpOk(new EmployeePermissionResource($employee));
    }

    public function verifyTwoFactor(): ResponseData
    {
        $result = $this->authService->verifyTokenTwoFactor();
        if ($result) {
            return $this->httpOk($result);
        }
        return $this->httpBadRequest(['token' => __('errors.main.10004')]);
    }
}
