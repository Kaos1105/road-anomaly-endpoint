<?php

namespace App\Repositories\Site;

use App\Models\Company;
use App\Models\Site;
use App\Query\Site\SiteDropdownQuery;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\RepositoryInterface;
use Spatie\QueryBuilder\QueryBuilder;

interface ISiteRepository extends RepositoryInterface
{
    public function getPaginateList(): LengthAwarePaginator;

    public function findAll(): Collection|array;

    public function getListSitesByCompany(int $companyId): Collection|array;

    public function getDetail(Site $site): Model|QueryBuilder;

    public function findByQuery(QueryBuilder $query): Collection|array;

    public function setRepresentativeSite(Company $company, int $representSiteId, array $dataUpdate): void;

    public function getSiteStores(SiteDropdownQuery $query): Collection|array;

    public function checkRelations(Site $site): Model|Site;

    public function getSiteContractDropdown(bool $isCounterparty = true): Collection;
}
