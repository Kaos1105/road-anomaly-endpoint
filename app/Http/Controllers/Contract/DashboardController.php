<?php

namespace App\Http\Controllers\Contract;

use App\Http\Controllers\Controller;
use App\Http\DTO\ResponseData;

use App\Services\AccessHistory\IAccessHistoryService;

class DashboardController extends Controller
{
    public function __construct(
        private readonly IAccessHistoryService $accessHistoryService,
    )
    {
    }


    public function basicContractHistory(): ResponseData
    {
        return $this->httpOk();
    }

    public function individualContractHistory(): ResponseData
    {
        return $this->httpOk();
    }

    public function basicContractList(): ResponseData
    {
        return $this->httpOk();
    }

}
