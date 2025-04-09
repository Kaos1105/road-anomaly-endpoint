<?php

namespace App\Repositories\ChatThread;

use App\Models\ChatThread;
use App\Models\Employee;
use Illuminate\Database\Eloquent\Collection;
use Prettus\Repository\Contracts\RepositoryInterface;

interface IChatThreadRepository extends RepositoryInterface
{
    public function getUserChatThread(): Employee;

    public function markChatThreadAsRead(ChatThread $chatThread): int;

    public function getNotificationChatThreads(): Collection;

    public function getAllChatThreads(int $adminEmployeeId): Collection;

    public function getDashboardUnreadThread(int $employeeId): Collection;
}
