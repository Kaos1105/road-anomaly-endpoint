<?php

namespace App\Services\ChatThread;

use App\Repositories\ChatThread\IChatThreadRepository;
use Illuminate\Database\Eloquent\Collection;

interface IChatThreadService
{
    public function getRepo(): IChatThreadRepository;

    public function dispatchChatEventToAdmin();

    public function getAdminChatThreads(int $authEmployeeId): array;

    public function getDashboardUnreadThread(): Collection;

}
