<?php

namespace App\Http\Controllers\Contract;

use App\Enums\Common\UseFlagEnum;
use App\Http\Controllers\Controller;
use App\Http\DTO\QueryParam\EmployeeDropdownContractParam;
use App\Http\DTO\QueryParam\SiteDropdownContractParam;
use App\Http\DTO\ResponseData;
use App\Http\Resources\Company\CompanyDropdownResource;
use App\Http\Resources\Division\DivisionDropdownResource;
use App\Http\Resources\Employee\EmployeeNameResource;
use App\Http\Resources\Site\SiteContractResource;
use App\Http\Resources\Site\SiteDropdownResource;
use App\Query\Employee\EmployeeContractQuery;
use App\Query\Site\SiteDropdownContractQuery;
use App\Services\Company\ICompanyService;
use App\Services\Division\IDivisionService;
use App\Services\Employee\IEmployeeService;
use App\Services\Site\ISiteService;

class DropdownController extends Controller
{
    public function __construct(
        private readonly ICompanyService  $companyService,
        private readonly ISiteService     $siteService,
        private readonly IEmployeeService $employeeService,
        private readonly IDivisionService $divisionService,
    )
    {
    }

    public function dropdownSiteCompanyContract(): ResponseData
    {
        $sites = $this->siteService->getSiteContractDropdown();
        return $this->httpOk(SiteContractResource::collection($sites));
    }

    public function dropdownEmployeeContract(): ResponseData
    {
        return $this->httpOk();
    }

    public function dropdownSite(SiteDropdownContractQuery $query): ResponseData
    {
        $sites = $this->siteService->findByQuery($query->setFilterParam(new SiteDropdownContractParam(useClassification: UseFlagEnum::USE)));
        return $this->httpOk(SiteDropdownResource::collection($sites));
    }

    public function dropdownCompany(): ResponseData
    {
        $companies = $this->companyService->getCompanyContractDropdown();
        return $this->httpOk(CompanyDropdownResource::collection($companies));
    }

    public function dropdownEmployee(EmployeeContractQuery $query): ResponseData
    {
        $employees = $this->employeeService->findByQuery($query->setFilterParam(new EmployeeDropdownContractParam(useClassification: UseFlagEnum::USE)));
        return $this->httpOk(EmployeeNameResource::collection($employees));
    }

    public function dropdownDivision(): ResponseData
    {
        $division = $this->divisionService->getDivisionContractDropdown();
        return $this->httpOk(DivisionDropdownResource::collection($division));
    }

}
