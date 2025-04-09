<?php

namespace App\Repositories\ContractCondition;

use App\Models\ContractCondition;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\RepositoryInterface;
use Spatie\QueryBuilder\QueryBuilder;

interface IContractConditionRepository extends RepositoryInterface
{
    public function getPaginateList(): LengthAwarePaginator;

    public function findAll(): Collection|array;

    public function findByQuery(QueryBuilder $query): Collection|array;

    public function showDetail(ContractCondition $contractCondition): Model|QueryBuilder;

    public function checkRelations(ContractCondition $contractCondition): Model|ContractCondition;

}
