<?php

namespace App\Repositories\Negotiation;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Prettus\Repository\Contracts\RepositoryInterface;

interface INegotiationEmployeeRepository extends RepositoryInterface
{
    public function getPaginateList(): LengthAwarePaginator;

    public function findAll(): Collection|array;


}
