<?php

namespace App\Services\Site;

use App\Models\Site;
use App\Query\Site\SiteDropdownQuery;
use App\Repositories\Site\ISiteRepository;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\QueryBuilder;

interface ISiteService
{
    public function getRepo(): ISiteRepository;

    public function getChildNames(Site $site): ?string;

    public function deleteRecord(Site $site): void;

    public function findByQuery(QueryBuilder $query): Collection|array;

    public function getSiteSupplier(SiteDropdownQuery $query): Collection|array;

    public function getSiteContractDropdown(): Collection|array;
}
