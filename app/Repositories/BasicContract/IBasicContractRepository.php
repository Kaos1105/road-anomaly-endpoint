<?php

namespace App\Repositories\BasicContract;

use App\Models\BasicContract;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\RepositoryInterface;
use Spatie\QueryBuilder\QueryBuilder;

interface IBasicContractRepository extends RepositoryInterface
{
    public function getPaginateList(): LengthAwarePaginator;

    public function findAll(): Collection|array;

    public function findByQuery(QueryBuilder $query): Collection|array;

    public function showDetail(BasicContract $basicContract): Model|QueryBuilder;

    public function checkRelations(BasicContract $basicContract): Model|BasicContract;

}
