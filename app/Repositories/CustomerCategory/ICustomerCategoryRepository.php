<?php

namespace App\Repositories\CustomerCategory;

use App\Query\CustomerCategory\CustomerCategoryDropdownQuery;
use Illuminate\Database\Eloquent\Collection;
use Prettus\Repository\Contracts\RepositoryInterface;

interface ICustomerCategoryRepository extends RepositoryInterface
{
    public function findByQuery(CustomerCategoryDropdownQuery $query): Collection|array;
}
