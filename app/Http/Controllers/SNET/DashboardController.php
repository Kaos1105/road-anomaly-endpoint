<?php

namespace App\Http\Controllers\SNET;

use App\Http\Controllers\Controller;
use App\Http\DTO\ResponseData;
use App\Http\Resources\AuthenticationHistory\DashboardHistoryItemResource;
use App\Http\Resources\ChatThread\UnreadThreadDashboardResource;
use App\Http\Resources\System\SystemManagementItemResource;
use App\Services\AuthenticationHistory\IAuthenticationHistoryService;
use App\Services\ChatThread\IChatThreadService;
use App\Services\System\ISystemService;

class DashboardController extends Controller
{
    public function __construct(
        private readonly IChatThreadService            $chatThreadService,
        private readonly ISystemService                $systemService,
        private readonly IAuthenticationHistoryService $authenticationHistoryService,
    )
    {
    }

    public function getUnreadChatInfo(): ResponseData
    {
        $result = $this->chatThreadService->getDashboardUnreadThread();

        return $this->httpOk(UnreadThreadDashboardResource::collection($result));
    }

    public function getSystemManagement(): ResponseData
    {
        $systems = $this->systemService->getRepo()->getListSystemManagement();

        return $this->httpOk(SystemManagementItemResource::collection($systems));
    }

    public function getAuthenticationHistory(): ResponseData
    {
        $systems = $this->authenticationHistoryService->getHistoryCard();

        return $this->httpOk(DashboardHistoryItemResource::collection($systems));
    }
}
