<?php

namespace App\Services\ClientSite;

use App\Models\ClientSite;
use App\Repositories\ClientSite\IClientSiteRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\QueryBuilder;

interface IClientSiteService
{
    public function getRepo(): IClientSiteRepository;

    public function getPaginateList(): LengthAwarePaginator;

    public function getChildNames(ClientSite $clientSite): ?string;

    public function findByQuery(QueryBuilder $query): Collection|array;


}
