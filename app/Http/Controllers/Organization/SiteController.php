<?php

namespace App\Http\Controllers\Organization;

use App\Http\Controllers\Controller;
use App\Http\DTO\ResponseData;
use App\Http\Requests\Site\RepresentDepartmentRequest;
use App\Http\Requests\Site\UpsertSiteRequest;
use App\Http\Resources\Site\DepartmentItemBySiteResource;
use App\Http\Resources\Site\SiteCollection;
use App\Http\Resources\Site\SiteDetailResource;
use App\Http\Resources\Site\SiteDropdownResource;
use App\Models\Site;
use App\Query\Site\SiteDropdownQuery;
use App\Services\Department\IDepartmentService;
use App\Services\Site\ISiteService;

class SiteController extends Controller
{
    public function __construct(
        private readonly ISiteService       $siteService,
        private readonly IDepartmentService $departmentService
    )
    {
    }

    public function index(): ResponseData
    {
        $sites = $this->siteService->getRepo()->getPaginateList();

        return $this->httpOk(new SiteCollection($sites));
    }

    public function store(UpsertSiteRequest $request): ResponseData
    {
        $data = $request->validated();

        $site = $this->siteService->getRepo()->create($data);

        return $this->httpCreated(new SiteDetailResource($site));
    }

    public function show(Site $site): ResponseData
    {
        $result = $this->siteService->getRepo()->getDetail($site);
        return $this->httpOk(new SiteDetailResource($result));
    }

    public function update(UpsertSiteRequest $request, Site $site): ResponseData
    {
        $data = $request->validated();

        $result = $this->siteService->getRepo()->update($data, $site->id);

        return $this->httpOk(new SiteDetailResource($result));
    }

    public function destroy(Site $site): ResponseData
    {
        $childNames = $this->siteService->getChildNames($site);
        if ($childNames) {
            return $this->httpBadRequest(msg: __('errors.can_not_delete', ['attr1' => $childNames]));
        }
        $this->siteService->deleteRecord($site);

        return $this->httpNoContent();
    }

    public function getDepartments(Site $site): ResponseData
    {
        $departments = $this->departmentService->getRepo()->getListDepartmentsBySite($site->id);

        return $this->httpOk(DepartmentItemBySiteResource::collection($departments));
    }

    public function dropdownSites(SiteDropdownQuery $query): ResponseData
    {
        $result = $this->siteService->findByQuery($query);

        return $this->httpOk(SiteDropdownResource::collection($result));
    }

    public function setRepresentative(Site $site, RepresentDepartmentRequest $request): ResponseData
    {
        $representDepartmentId = $request->input('department_id');
        $dataUpdate = $request->only(['updated_at', 'updated_by']);
        $this->departmentService->getRepo()->setRepresentativeDepartment($site, $representDepartmentId, $dataUpdate);

        return $this->httpNoContent();
    }
}
