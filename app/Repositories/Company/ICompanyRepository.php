<?php

namespace App\Repositories\Company;

use App\Models\Company;
use App\Query\Company\CompanyDropdownQuery;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\RepositoryInterface;
use Spatie\QueryBuilder\QueryBuilder;

interface ICompanyRepository extends RepositoryInterface
{
    public function getPaginateList(): LengthAwarePaginator;

    public function findAll(): Collection|array;

    public function getGroupCompanyList(): Collection|array;

    public function findByQuery(QueryBuilder $query): Collection|array;

    public function showDetail(Company $company): Model|QueryBuilder;

    public static function checkExistShinichiro(): Model|Company|null;

    public function getCompanySupplier(CompanyDropdownQuery $query): Collection|array;

    public function checkRelations(Company $company): Model|Company;

    public function dropdownCustomerCompany(): Collection;

    public function getCompanyContractDropdown(bool $isCounterparty = true): Collection;
}
