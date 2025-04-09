<?php

namespace App\Http\Controllers\Social;

use App\Http\Controllers\Controller;
use App\Http\DTO\ResponseData;
use App\Http\Resources\Company\CompanyDropdownResource;
use App\Query\Company\CompanyDropdownQuery;
use App\Services\Company\ICompanyService;

class CompanyController extends Controller
{
    public function __construct(
        private readonly ICompanyService $companyService,
    )
    {
    }

    public function getCompanySupplier(CompanyDropdownQuery $query): ResponseData
    {
        $result = $this->companyService->getCompanySupplier($query);

        return $this->httpOk(CompanyDropdownResource::collection($result));
    }

    public function getCustomerCompany(): ResponseData
    {
        $result = $this->companyService->getRepo()->dropdownCustomerCompany();

        return $this->httpOk(CompanyDropdownResource::collection($result));
    }
}
