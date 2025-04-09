<?php

namespace App\Http\Controllers\Organization;

use App\Http\Controllers\Controller;
use App\Http\DTO\ResponseData;
use App\Http\Requests\Company\RepresentSiteRequest;
use App\Http\Requests\Company\UpsertCompanyRequest;
use App\Http\Resources\Company\CompanyCollection;
use App\Http\Resources\Company\CompanyDetailResource;
use App\Http\Resources\Company\CompanyDropdownResource;
use App\Http\Resources\Company\CompanyGroupNameResource;
use App\Http\Resources\Company\ShinichiroCompanyStatusResource;
use App\Http\Resources\Company\SiteItemByCompanyResource;
use App\Models\Company;
use App\Query\Company\CompanyDropdownQuery;
use App\Services\Company\ICompanyService;
use App\Services\Site\ISiteService;

class CompanyController extends Controller
{
    public function __construct(
        private readonly ICompanyService $companyService,
        private readonly ISiteService    $siteService
    )
    {
    }

    public function index(): ResponseData
    {
        $companies = $this->companyService->getRepo()->getPaginateList();
        return $this->httpOk(new CompanyCollection($companies));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UpsertCompanyRequest $request): ResponseData
    {
        $data = $request->validated();
        $result = $this->companyService->getRepo()->create($data);

        return $this->httpCreated(new CompanyDetailResource($result));
    }

    public function show(Company $company): ResponseData
    {
        $company = $this->companyService->getRepo()->showDetail($company);
        return $this->httpOk(new CompanyDetailResource($company));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpsertCompanyRequest $request, Company $company): ResponseData
    {
        $data = $request->validated();
        $result = $this->companyService->getRepo()->update($data, $company->id);
        return $this->httpOk(new CompanyDetailResource($result));
    }

    public function destroy(Company $company): ResponseData
    {
        $childNames = $this->companyService->getChildNames($company);
        if ($childNames) {
            return $this->httpBadRequest(msg: __('errors.can_not_delete', ['attr1' => $childNames]));
        }
        $this->companyService->deleteRecord($company);
        return $this->httpNoContent();
    }

    public function dropdown(): ResponseData
    {
        $groupCompany = $this->companyService->getRepo()->getGroupCompanyList();

        return $this->httpOk(CompanyGroupNameResource::collection($groupCompany));
    }

    public function getSites(Company $company): ResponseData
    {
        $sites = $this->siteService->getRepo()->getListSitesByCompany($company->id);

        return $this->httpOk(SiteItemByCompanyResource::collection($sites));
    }

    public function dropdownCompany(CompanyDropdownQuery $query): ResponseData
    {
        $companies = $this->companyService->getRepo()->findByQuery($query);

        return $this->httpOk(CompanyDropdownResource::collection($companies));
    }

    public function setRepresentative(Company $company, RepresentSiteRequest $request): ResponseData
    {
        $representSiteId = $request->input('site_id');
        $dataUpdate = $request->only(['updated_at', 'updated_by']);
        $this->siteService->getRepo()->setRepresentativeSite($company, $representSiteId, $dataUpdate);

        return $this->httpNoContent();

    }

    public function checkShinnichiro(): ResponseData
    {
        $shinnichiro = $this->companyService->getRepo()->checkExistShinichiro();

        return $this->httpOk(ShinichiroCompanyStatusResource::make($shinnichiro));
    }
}
