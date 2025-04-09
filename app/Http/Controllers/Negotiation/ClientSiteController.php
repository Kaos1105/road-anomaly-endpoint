<?php

namespace App\Http\Controllers\Negotiation;

use App\Http\Controllers\Controller;
use App\Http\DTO\QueryParam\ClientSiteDropdownParam;
use App\Http\DTO\QueryParam\CompanyDropdownNegotiationParam;
use App\Http\DTO\QueryParam\SiteDropdownNegotiationParam;
use App\Http\DTO\ResponseData;
use App\Http\Requests\ClientSite\UpsertClientSiteRequest;
use App\Http\Resources\ClientSite\ClientSiteCollection;
use App\Http\Resources\ClientSite\ClientSiteDetailResource;
use App\Http\Resources\ClientSite\ClientSiteDropdownResource;
use App\Http\Resources\Company\CompanyDropdownResource;
use App\Http\Resources\Negotiation\NegotiationItemClientSiteResource;
use App\Http\Resources\Site\SiteRelatedResource;
use App\Models\ClientSite;
use App\Query\Company\CompanyDropdownNegotiationQuery;
use App\Query\Negotiation\ClientSiteDropdownQuery;
use App\Query\Site\SiteDropdownNegotiationQuery;
use App\Services\ClientSite\IClientSiteService;
use App\Services\Company\ICompanyService;
use App\Services\Negotiation\INegotiationService;
use App\Services\Site\ISiteService;

class ClientSiteController extends Controller
{
    public function __construct(
        private readonly IClientSiteService  $clientSiteService,
        private readonly ICompanyService     $companyService,
        private readonly ISiteService        $siteService,
        private readonly INegotiationService $negotiationService,
    )
    {
    }

    public function index(): ResponseData
    {
        $result = $this->clientSiteService->getPaginateList();
        return $this->httpOk(new ClientSiteCollection($result));
    }

    public function store(UpsertClientSiteRequest $request): ResponseData
    {
        $data = $request->validated();
        $clientSite = $this->clientSiteService->getRepo()->create($data);
        $result = $this->clientSiteService->getRepo()->getDetail($clientSite);
        return $this->httpCreated(ClientSiteDetailResource::make($result));
    }

    public function show(ClientSite $clientSite): ResponseData
    {
        $result = $this->clientSiteService->getRepo()->getDetail($clientSite);
        return $this->httpOk(new ClientSiteDetailResource($result));
    }

    public function update(UpsertClientSiteRequest $request, ClientSite $clientSite): ResponseData
    {
        $data = $request->validated();
        $clientSite = $this->clientSiteService->getRepo()->update($data, $clientSite->id);
        $result = $this->clientSiteService->getRepo()->getDetail($clientSite);
        return $this->httpOk(new ClientSiteDetailResource($result));
    }

    public function destroy(ClientSite $clientSite): ResponseData
    {
        $childNames = $this->clientSiteService->getChildNames($clientSite);
        if ($childNames) {
            return $this->httpBadRequest(msg: __('errors.can_not_delete', ['attr1' => $childNames]));
        }
        $this->clientSiteService->getRepo()->delete($clientSite->id);

        return $this->httpNoContent();
    }

    public function dropdownCompany(CompanyDropdownNegotiationQuery $query): ResponseData
    {
        $result = $this->companyService->getRepo()->findByQuery($query->setFilterParam(new CompanyDropdownNegotiationParam()));

        return $this->httpOk(CompanyDropdownResource::collection($result));
    }

    public function dropdownSite(SiteDropdownNegotiationQuery $query): ResponseData
    {
        $result = $this->siteService->findByQuery($query->setFilterParam(new SiteDropdownNegotiationParam()));

        return $this->httpOk(SiteRelatedResource::collection($result));
    }

    public function dropdownClientSite(ClientSiteDropdownQuery $query): ResponseData
    {
        $result = $this->clientSiteService->findByQuery($query->setFilterParam(new ClientSiteDropdownParam()));

        return $this->httpOk(ClientSiteDropdownResource::collection($result));
    }

    public function getNegotiations(ClientSite $clientSite): ResponseData
    {
        $result = $this->negotiationService->getRepo()->findAllByClientSite($clientSite);

        return $this->httpOk(NegotiationItemClientSiteResource::collection($result));
    }

}
