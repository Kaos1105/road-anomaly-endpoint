<?php

namespace App\Http\Controllers\Social;

use App\Http\Controllers\Controller;
use App\Http\DTO\ResponseData;
use App\Http\Resources\Site\SiteRelatedResource;
use App\Query\Site\SiteDropdownQuery;
use App\Services\Site\ISiteService;

class SiteController extends Controller
{
    public function __construct(
        private readonly ISiteService $siteService,
    )
    {
    }

    public function getSiteSupplier(SiteDropdownQuery $query): ResponseData
    {
        $result = $this->siteService->getSiteSupplier($query);

        return $this->httpOk(SiteRelatedResource::collection($result));
    }

}
