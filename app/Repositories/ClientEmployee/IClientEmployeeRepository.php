<?php

namespace App\Repositories\ClientEmployee;

use App\Models\ClientEmployee;
use App\Models\ClientSite;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\RepositoryInterface;
use Spatie\QueryBuilder\QueryBuilder;

interface IClientEmployeeRepository extends RepositoryInterface
{
    public function getPaginateList(): LengthAwarePaginator;

    public function findAll(ClientSite $clientSite): Collection|array;

    public function getDetail(ClientEmployee $clientEmployee): Model|QueryBuilder;

    public function checkRelations(ClientEmployee $clientEmployee): Model|ClientEmployee;

    public function findByQuery(QueryBuilder $query): Collection|array;
}
