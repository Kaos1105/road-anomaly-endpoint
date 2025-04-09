<?php

namespace App\Http\Controllers\SNET;

use App\Http\Controllers\Controller;

use App\Http\DTO\ResponseData;
use App\Http\Resources\AuthenticationHistory\AuthenticationHistoryCollection;
use App\Services\AuthenticationHistory\IAuthenticationHistoryService;

class AuthenticationHistoryController extends Controller
{
    public function __construct(
        private readonly IAuthenticationHistoryService $authenticationHistoryService,
    )
    {
    }

    public function index(): ResponseData
    {
        $history = $this->authenticationHistoryService->getRepo()->getPaginateList();

        return $this->httpOk(new AuthenticationHistoryCollection($history));
    }

    public function dropdownYears(): ResponseData
    {
        $years = $this->authenticationHistoryService->getListYears();
        return $this->httpOk($years);
    }

    public function summary(): ResponseData
    {
        $summary = $this->authenticationHistoryService->getSummary();
        return $this->httpOk($summary);
    }

}
