<?php

namespace App\Services\Auth;

use App\Http\DTO\Auth\AuthUserData;
use App\Http\DTO\ResponseData;
use App\Models\Employee;
use App\Models\Login;
use App\Models\System;
use App\Repositories\Auth\IAuthRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

interface IAuthService
{
    public function getRepo(): IAuthRepository;

    public function clearEmployeePermission(Collection $collection): int;

    public function clearUserToken(Collection $collection): int;

    public function clearAccessedToken(System $system): int;

    public function sendMailVerify(Login $login): bool;

    public function isPasswordExpired(Login $login): bool;

    public function handleNotImplementAuth(Login $login): ResponseData|null;

    public function checkPreviousLoginExpired(Login $login): ResponseData|null;

    public function isUserAllowed(Employee $employee): ResponseData|null;

    public function verifyTokenTwoFactor(): AuthUserData|null;

    public function createToken(Login $login, Request $request): AuthUserData;
}
