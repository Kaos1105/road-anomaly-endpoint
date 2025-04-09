<?php

namespace App\Repositories\IndividualContract;

use App\Models\BasicContract;
use App\Models\IndividualContract;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\RepositoryInterface;
use Spatie\QueryBuilder\QueryBuilder;

interface IIndividualContractRepository extends RepositoryInterface
{
    public function getPaginateList(): LengthAwarePaginator;

    public function findAll(BasicContract $basicContract): Collection|array;

    public function findByQuery(QueryBuilder $query): Collection|array;

    public function showDetail(IndividualContract $individualContract): Model|QueryBuilder;


}
