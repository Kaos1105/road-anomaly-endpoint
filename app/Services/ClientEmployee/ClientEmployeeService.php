<?php

namespace App\Services\ClientEmployee;

use App\Models\ClientEmployee;
use App\Models\ClientSite;
use App\Repositories\ClientEmployee\IClientEmployeeRepository;
use BenSampo\Enum\Exceptions\InvalidEnumKeyException;
use DB;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Throwable;

readonly class ClientEmployeeService implements IClientEmployeeService
{
    public function __construct(
        private IClientEmployeeRepository $clientEmployeeRepository,
    )
    {
    }

    public function getRepo(): IClientEmployeeRepository
    {
        return $this->clientEmployeeRepository;
    }

    public function getChildNames(ClientEmployee $clientEmployee): ?string
    {
        $countRelation = $this->clientEmployeeRepository->checkRelations($clientEmployee);
        if ($countRelation->negotiable_count > 0) {
            return __('attributes.negotiation.table');
        }
        return null;
    }

    /**
     * @throws InvalidEnumKeyException
     * @throws Throwable
     */
    public function deleteRecord(ClientEmployee $clientEmployee): void
    {
        DB::transaction(function () use ($clientEmployee) {
            $clientEmployee->delete();
        });
    }

    public function createRecord(ClientSite $clientSite, array $dataInsert): ClientEmployee|null
    {
        $dataInsert['client_site_id'] = $clientSite->id;
        return $this->clientEmployeeRepository->create($dataInsert);
    }

    public function findByQuery(QueryBuilder $query): Collection|array
    {
        if (empty(request('filter')['client_site_id'])) {
            return collect();
        }
        return $this->clientEmployeeRepository->findByQuery($query);
    }

}
