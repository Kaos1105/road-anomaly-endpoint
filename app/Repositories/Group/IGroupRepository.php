<?php

namespace App\Repositories\Group;

use App\Models\Group;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\RepositoryInterface;
use Spatie\QueryBuilder\QueryBuilder;

interface IGroupRepository extends RepositoryInterface
{
    public function getPaginateList(): LengthAwarePaginator;

    public function findAll(): Collection|array;

    public function getGroupBothEmployeeAndUser(): Collection;

    public function getDetail(Group $group): Model|QueryBuilder;

}

