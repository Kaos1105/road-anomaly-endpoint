<?php

namespace App\Repositories\Department;

use App\Models\Department;
use App\Models\Site;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\RepositoryInterface;
use Spatie\QueryBuilder\QueryBuilder;

interface IDepartmentRepository extends RepositoryInterface
{
    public function getPaginateList(): LengthAwarePaginator;

    public function findAll(): Collection|array;

    public function getListDepartmentsBySite(int $siteId): Collection|array;

    public function getDetail(Department $department): Model|QueryBuilder;

    public function setRepresentativeDepartment(Site $site, int $representDepartmentId, array $dataUpdate): void;

    public function findByQuery(QueryBuilder $query): Collection|array;

    public function getShinichiroDepartments(): Collection|array;

    public function dropdownShinnichiroDepartment(): Collection|array;

    public function checkRelations(Department $department): Model|Department;
}
