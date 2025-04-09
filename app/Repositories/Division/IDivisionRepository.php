<?php

namespace App\Repositories\Division;

use App\Models\Department;
use App\Models\Division;
use App\Query\Division\DivisionDropdownQuery;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\RepositoryInterface;
use Spatie\QueryBuilder\QueryBuilder;

interface IDivisionRepository extends RepositoryInterface
{
    public function getPaginateList(): LengthAwarePaginator;

    public function findAll(): Collection|array;

    public function showDetail(Division $division): Model|QueryBuilder;

    public function getListDivisionsByDepartment(Department $department): Collection|array;

    public function setRepresentativeDivision(Department $department, int $representDivisionId, array $dataUpdate): void;

    public function findByQuery(QueryBuilder $query): Collection|array;

    public function checkRelations(Division $division): Model|Division;
}
