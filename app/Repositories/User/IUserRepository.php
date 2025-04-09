<?php

namespace App\Repositories\User;

use App\Http\DTO\Auth\LoginData;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\RepositoryInterface;
use Spatie\QueryBuilder\QueryBuilder;

interface IUserRepository extends RepositoryInterface
{
    public function getPaginateList(): LengthAwarePaginator;

    public function findAll(): Collection|array;

    public function showWithRelationship(string $id): Model|QueryBuilder;

    public function getDataLogin(LoginData $loginData): ?User;
}
