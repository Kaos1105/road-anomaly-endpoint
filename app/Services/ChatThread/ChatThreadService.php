<?php

namespace App\Services\ChatThread;

use App\Enums\System\SystemCodeEnum;
use App\Http\Resources\ChatThread\ChatThreadItemResource;
use App\Jobs\ProcessChatThreadsForAdmin;
use App\Jobs\SendAllChatThread;
use App\Models\ChatThread;
use App\Repositories\ChatThread\IChatThreadRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class ChatThreadService implements IChatThreadService
{
    public function __construct(
        private IChatThreadRepository $chatTheadRepository,
    )
    {
    }

    public function getRepo(): IChatThreadRepository
    {
        return $this->chatTheadRepository;
    }

    public function dispatchChatEventToAdmin(): void
    {
        ProcessChatThreadsForAdmin::dispatch(SystemCodeEnum::SNET);
    }

    public function dispatchChatEventToCurrentAdmin(): void
    {
        $authEmployeeId = \Auth::user()->employee_id;
        $result = $this->chatTheadRepository->getAllChatThreads($authEmployeeId);
        $resourceCollection = $result->map(function (ChatThread $chatThread) use ($authEmployeeId) {
            return (new ChatThreadItemResource($chatThread))->setParams($authEmployeeId)->toArray(request());
        });

        if ($resourceCollection->count()) {
            SendAllChatThread::dispatch($resourceCollection->toArray());
        }
    }

    public function getAdminChatThreads(int $authEmployeeId): array
    {
        $result = $this->getRepo()->getAllChatThreads($authEmployeeId);

        return $result->map(function (ChatThread $chatThread) use ($authEmployeeId) {
            return (new ChatThreadItemResource($chatThread))->setParams($authEmployeeId);
        })->toArray();
    }

    public function getDashboardUnreadThread(): Collection
    {
        $authEmployeeId = Auth::user()->employee_id;
        return $this->chatTheadRepository->getDashboardUnreadThread($authEmployeeId);
    }
}
