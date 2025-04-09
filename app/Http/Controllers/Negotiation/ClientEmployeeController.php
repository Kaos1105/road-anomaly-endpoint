<?php

namespace App\Http\Controllers\Negotiation;

use App\Http\Controllers\Controller;
use App\Http\DTO\Negotiation\ClientEmployeeDetailData;
use App\Http\DTO\QueryParam\ClientEmployeeDropdownParam;
use App\Http\DTO\ResponseData;
use App\Http\Requests\ClientEmployee\UpsertClientEmployeeRequest;
use App\Http\Resources\ClientSite\ClientEmployee\ClientEmployeeDropdownResource;
use App\Http\Resources\ClientSite\ClientEmployeeItemResource;
use App\Models\ClientEmployee;
use App\Models\ClientSite;
use App\Query\Negotiation\ClientEmployeeDropdownQuery;
use App\Services\ClientEmployee\IClientEmployeeService;

class ClientEmployeeController extends Controller
{
    public function __construct(
        private readonly IClientEmployeeService $clientEmployeeService,
    )
    {
    }

    public function index(ClientSite $clientSite): ResponseData
    {
        $result = $this->clientEmployeeService->getRepo()->findAll($clientSite);
        return $this->httpOk(ClientEmployeeItemResource::collection($result));
    }

    public function store(ClientSite $clientSite, UpsertClientEmployeeRequest $request): ResponseData
    {
        $data = $request->validated();
        $clientEmployee = $this->clientEmployeeService->createRecord($clientSite, $data);

        return $this->httpOk(ClientEmployeeDetailData::fromModel($clientEmployee, $clientSite));
    }

    public function show(ClientSite $clientSite, ClientEmployee $employee): ResponseData
    {
        return $this->httpOk(ClientEmployeeDetailData::fromModel($employee, $clientSite));
    }

    public function update(UpsertClientEmployeeRequest $request, ClientSite $clientSite, ClientEmployee $employee): ResponseData
    {
        $data = $request->validated();
        $clientEmployee = $this->clientEmployeeService->getRepo()->update($data, $employee->id);

        return $this->httpOk(ClientEmployeeDetailData::fromModel($clientEmployee, $clientSite));
    }

    public function destroy(ClientSite $clientSite, ClientEmployee $employee): ResponseData
    {

        $childNames = $this->clientEmployeeService->getChildNames($employee);
        if ($childNames) {
            return $this->httpBadRequest(msg: __('errors.can_not_delete', ['attr1' => $childNames]));
        }

        $this->clientEmployeeService->getRepo()->delete($employee->id);
        return $this->httpNoContent();
    }


    public function dropdownClientEmployee(ClientEmployeeDropdownQuery $query): ResponseData
    {
        $result = $this->clientEmployeeService->findByQuery($query->setFilterParam(new ClientEmployeeDropdownParam()));

        return $this->httpOk(ClientEmployeeDropdownResource::collection($result));
    }

}
