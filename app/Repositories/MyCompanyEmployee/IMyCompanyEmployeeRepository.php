<?php

namespace App\Repositories\MyCompanyEmployee;

use App\Models\ManagementDepartment;
use App\Models\MyCompanyEmployee;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\RepositoryInterface;
use Spatie\QueryBuilder\QueryBuilder;

interface IMyCompanyEmployeeRepository extends RepositoryInterface
{
    public function getPaginateList(): LengthAwarePaginator;

    public function findAll(ManagementDepartment $managementDepartment): Collection|array;

    public function showDetail(MyCompanyEmployee $myCompanyEmployee): Model|QueryBuilder;

    public function checkRelations(MyCompanyEmployee $myCompanyEmployee): Model|MyCompanyEmployee|null;

    public function findByQuery(QueryBuilder $query): Collection|array;
}
