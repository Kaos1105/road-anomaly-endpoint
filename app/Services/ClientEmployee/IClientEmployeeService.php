<?php

namespace App\Services\ClientEmployee;

use App\Models\ClientEmployee;
use App\Models\ClientSite;
use App\Repositories\ClientEmployee\IClientEmployeeRepository;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\QueryBuilder;

interface IClientEmployeeService
{
    public function getRepo(): IClientEmployeeRepository;

    public function getChildNames(ClientEmployee $clientEmployee): ?string;

    public function deleteRecord(ClientEmployee $clientEmployee): void;

    public function createRecord(ClientSite $clientSite, array $dataInsert): ClientEmployee|null;

    public function findByQuery(QueryBuilder $query): Collection|array;
}
