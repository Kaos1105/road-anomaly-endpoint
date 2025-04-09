<?php

namespace App\Repositories\Auth;

use App\Http\DTO\Auth\LoginData;
use App\Models\Login;
use Illuminate\Database\Eloquent\Collection;
use Prettus\Repository\Contracts\RepositoryInterface;

interface IAuthRepository extends RepositoryInterface
{
    public function findAll(): Collection|array;

    public function showWithRelationship(Login $login): Login;

    public function getUserLogin(LoginData $loginData): ?Login;

    public function updateInactivityExpires(Login $login): bool;

    public function updateLogin(Login $login, array $updateData): bool;

    public function findLogin(int $employeeId): Login|null;
}
