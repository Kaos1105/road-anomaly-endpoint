<?php

namespace App\Repositories\ClientSite;

use App\Models\ClientSite;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\RepositoryInterface;
use Spatie\QueryBuilder\QueryBuilder;

interface IClientSiteRepository extends RepositoryInterface
{
    public function getPaginateList(): LengthAwarePaginator;

    public function findAll(): Collection|array;

    public function getDetail(ClientSite $clientSite): Model|QueryBuilder;

    public function checkRelations(ClientSite $clientSite): Model|ClientSite;

    public function findByQuery(QueryBuilder $query): Collection|array;

    public static function countClientSitesByManagementDepartments(array $managementDepartmentIds): int;
}
