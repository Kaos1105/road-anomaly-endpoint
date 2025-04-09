<?php

namespace App\Http\Controllers\Negotiation;

use App\Http\Controllers\Controller;
use App\Http\DTO\Negotiation\CalendarData;
use App\Http\DTO\Negotiation\ManagementDepartmentDashboardData;
use App\Http\DTO\ResponseData;
use App\Http\Requests\Negotiation\CommentNegotiationRequest;
use App\Http\Requests\Negotiation\UpsertNegotiationRequest;
use App\Http\Resources\Negotiation\NegotiationCollection;
use App\Http\Resources\Negotiation\NegotiationDetailResource;
use App\Http\Resources\Negotiation\NegotiationLikeResource;
use App\Models\Negotiation;
use App\Services\ClientSite\IClientSiteService;
use App\Services\ManagementDepartment\IManagementDepartmentService;
use App\Services\Negotiation\INegotiationService;

class NegotiationController extends Controller
{
    public function __construct(
        private readonly INegotiationService          $negotiationService,
        private readonly IManagementDepartmentService $managementDepartmentService,
        private readonly IClientSiteService           $clientSiteService,

    )
    {
    }

    public function dropdownManagementDepartmentDashboard(): ResponseData
    {
        $managementDepartments = $this->managementDepartmentService->allManagementDepartmentsByAuth();
        $clientSiteCount = $this->clientSiteService->getRepo()->findAll()->count();
        return $this->httpOk(ManagementDepartmentDashboardData::fromData($managementDepartments, $clientSiteCount));
    }

    public function calendar(): ResponseData
    {
        $data = $this->negotiationService->showCalendar();
        return $this->httpOk(CalendarData::fromCollection($data)->toArray());
    }

    public function index(): ResponseData
    {
        $result = $this->negotiationService->getPaginateList();
        return $this->httpOk(new NegotiationCollection($result));
    }

    public function store(UpsertNegotiationRequest $request): ResponseData
    {
        $data = $request->validated();
        $history = $this->negotiationService->createRecord($data);
        $result = $this->negotiationService->getRepo()->showDetail($history);
        return $this->httpOk(NegotiationDetailResource::make($result));
    }

    public function show(Negotiation $history): ResponseData
    {
        $result = $this->negotiationService->getRepo()->showDetail($history);
        return $this->httpOk(NegotiationDetailResource::make($result));
    }

    public function update(UpsertNegotiationRequest $request, Negotiation $history): ResponseData
    {
        $data = $request->validated();
        $history = $this->negotiationService->updateRecord($data, $history);
        $result = $this->negotiationService->getRepo()->showDetail($history);
        return $this->httpOk(NegotiationDetailResource::make($result));
    }

    public function comment(CommentNegotiationRequest $request, Negotiation $history): ResponseData
    {
        $data = $request->validated();
        $history = $this->negotiationService->getRepo()->update($data, $history->id);
        $result = $this->negotiationService->getRepo()->showDetail($history);
        return $this->httpOk(NegotiationDetailResource::make($result));
    }

    public function destroy(Negotiation $history): ResponseData
    {
        $this->negotiationService->deleteRecord($history);

        return $this->httpNoContent();
    }

    public function like(Negotiation $history): ResponseData
    {
        $history = $this->negotiationService->getRepo()->updateLike($history);
        return $this->httpOk(NegotiationLikeResource::make($history));
    }

}
