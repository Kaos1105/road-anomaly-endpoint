<?php

namespace App\Http\Controllers\SNET;

use App\Http\Controllers\Controller;
use App\Http\DTO\AccessHistory\AccessHistoryData;
use App\Http\DTO\AccessHistory\AccessHistoryEmployeeData;
use App\Http\DTO\ResponseData;
use App\Http\Requests\AccessHistory\CreateAccessHistoryRequest;
use App\Http\Requests\AccessHistory\UpsertAccessHistoryRequest;
use App\Http\Resources\AccessHistory\AccessCompanyItemResource;
use App\Http\Resources\AccessHistory\AccessDetailResource;
use App\Http\Resources\AccessHistory\AccessHistoryCollection;
use App\Http\Resources\AccessHistory\AccessItemResource;
use App\Http\Resources\AccessHistory\LoginHistoryResource;
use App\Services\AccessHistory\IAccessHistoryService;

class AccessHistoryController extends Controller
{
    public function __construct(
        private readonly IAccessHistoryService $accessHistoryService,
    )
    {
    }

    public function store(CreateAccessHistoryRequest $request): ResponseData
    {
        $data = $request->validated();

        $history = $this->accessHistoryService->getRepo()->create($data);

        return $this->httpCreated(new AccessDetailResource($history));
    }

    public function createAccessHistories(UpsertAccessHistoryRequest $request): ResponseData
    {
        $data = $request->validated();
        $histories = collect(AccessHistoryData::collect($data['access_histories']));
        $this->accessHistoryService->insertAccessPermissions($histories);

        return $this->httpCreated($histories->toArray());
    }

    public function getTopicDashboard(): ResponseData
    {
        $history = $this->accessHistoryService->getTopicAccessHistories();

        return $this->httpOk(AccessItemResource::collection($history));
    }

    public function getHistoryCompany(): ResponseData
    {
        $history = $this->accessHistoryService->getCompanyAccessHistories();

        return $this->httpOk(AccessCompanyItemResource::collection($history));
    }

    public function getHistoryEmployee(): ResponseData
    {
        $history = $this->accessHistoryService->getEmployeeAccessHistories();

        return $this->httpOk(AccessHistoryEmployeeData::mapCollection($history)->toArray());
    }

    public function getHistoryShinichiroEmployee(): ResponseData
    {
        $history = $this->accessHistoryService->getEmployeeShinichiroAccessHistories();

        return $this->httpOk(AccessHistoryEmployeeData::mapCollection($history, true)->toArray());
    }

    public function index(): ResponseData
    {
        $history = $this->accessHistoryService->getRepo()->getPaginateList();

        return $this->httpOk(new AccessHistoryCollection($history));
    }

    public function getUserPermissionSettingDashboard(): ResponseData
    {
        $history = $this->accessHistoryService->getUserPermissionSetting();

        return $this->httpOk($history);
    }

    public function getAccessHistoryLogin(): ResponseData
    {
        $history = $this->accessHistoryService->getLoginSNETDashboard();

        return $this->httpOk(LoginHistoryResource::collection($history));
    }

    public function dropdownYear(): ResponseData
    {
        $history = $this->accessHistoryService->getListYears();
        return $this->httpOk($history);
    }

    public function summarySystem(): ResponseData
    {
        $summary = $this->accessHistoryService->getSummarySystem();
        return $this->httpOk($summary?->toArray());
    }

    public function summaryUser(): ResponseData
    {
        $summary = $this->accessHistoryService->getSummaryUser();
        return $this->httpOk($summary?->toArray());
    }

    public function summaryTime(): ResponseData
    {
        $summary = $this->accessHistoryService->getSummaryTime();
        return $this->httpOk($summary?->toArray());
    }
}
