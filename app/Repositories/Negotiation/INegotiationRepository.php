<?php

namespace App\Repositories\Negotiation;

use App\Models\ClientSite;
use App\Models\Negotiation;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\RepositoryInterface;
use Spatie\QueryBuilder\QueryBuilder;

interface INegotiationRepository extends RepositoryInterface
{
    public function getPaginateList(): LengthAwarePaginator;

    public function findAllByClientSite(ClientSite $clientSite): Collection|array;

    public function getCalendar(QueryBuilder $query): Collection|array;

    public function showDetail(Negotiation $negotiation): Model|QueryBuilder;

    public function updateLike(Negotiation $negotiation): Negotiation;

}
