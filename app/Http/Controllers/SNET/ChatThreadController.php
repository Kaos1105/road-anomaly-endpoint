<?php

namespace App\Http\Controllers\SNET;

use App\Http\Controllers\Controller;
use App\Http\DTO\ResponseData;
use App\Http\Resources\ChatThread\ChatThreadItemResource;
use App\Http\Resources\Employee\EmployeeThreadResource;
use App\Jobs\SendAllChatThread;
use App\Models\ChatThread;
use App\Services\ChatThread\IChatThreadService;

class ChatThreadController extends Controller
{
    public function __construct(
        private readonly IChatThreadService $chatThreadService
    )
    {
    }

    public function getAllChatThreads(): ResponseData
    {
        $authEmployeeId = \Auth::user()->employee_id;
        $result = $this->chatThreadService->getAdminChatThreads($authEmployeeId);

        return $this->httpOk($result);
    }

    public function getUserChatThread(): ResponseData
    {
        $employee = $this->chatThreadService->getRepo()->getUserChatThread();

        return $this->httpOk(EmployeeThreadResource::make($employee));
    }

    public function markChatThreadRead(ChatThread $chatThread): ResponseData
    {
        $result = $this->chatThreadService->getRepo()->markChatThreadAsRead($chatThread);
        $this->chatThreadService->dispatchChatEventToCurrentAdmin();

        return $this->httpOk();
    }
}
