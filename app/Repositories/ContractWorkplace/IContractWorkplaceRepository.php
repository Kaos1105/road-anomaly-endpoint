<?php

namespace App\Repositories\ContractWorkplace;

use App\Models\BasicContract;
use App\Models\ContractWorkplace;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\RepositoryInterface;
use Spatie\QueryBuilder\QueryBuilder;

interface IContractWorkplaceRepository extends RepositoryInterface
{
    public function getPaginateList(): LengthAwarePaginator;

    public function findAll(BasicContract $basicContract): Collection|array;

    public function findByQuery(QueryBuilder $query): Collection|array;

    public function showDetail(ContractWorkplace $contractWorkplace): Model|QueryBuilder;


}
