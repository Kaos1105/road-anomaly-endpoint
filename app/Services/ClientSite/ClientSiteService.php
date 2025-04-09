<?php

namespace App\Services\ClientSite;

use App\Enums\Company\IndependentEnum;
use App\Models\ClientSite;
use App\Repositories\ClientSite\IClientSiteRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\QueryBuilder;


readonly class ClientSiteService implements IClientSiteService
{
    public function __construct(
        private IClientSiteRepository $clientSiteRepository,
    )
    {
    }

    public function getRepo(): IClientSiteRepository
    {
        return $this->clientSiteRepository;
    }

    public function getPaginateList(): LengthAwarePaginator
    {
        $request = request();
        $filter = $request['filter'];
        if (empty($filter['management_department_id'])) {
            $filter['management_department_id'] = IndependentEnum::INDEPENDENT;
        }

        $request->merge(['filter' => $filter]);
        return $this->clientSiteRepository->getPaginateList();
    }

    public function getChildNames(ClientSite $clientSite): ?string
    {
        $countRelation = $this->clientSiteRepository->checkRelations($clientSite);
        if ($countRelation->client_employees_count > 0) {
            return __('attributes.client_employee.table');
        }
        if ($countRelation->negotiations_count > 0) {
            return __('attributes.negotiation.table');
        }
        return null;
    }

    public function findByQuery(QueryBuilder $query): Collection|array
    {
        return $this->clientSiteRepository->findByQuery($query);
    }

}
