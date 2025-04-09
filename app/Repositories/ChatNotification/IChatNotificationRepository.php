<?php

namespace App\Repositories\ChatNotification;

use App\Models\ChatContent;
use Illuminate\Support\Collection;
use Prettus\Repository\Contracts\RepositoryInterface;

interface IChatNotificationRepository extends RepositoryInterface
{
    public function createClientSenderNotification(ChatContent $chatContent, Collection $employeeIds): bool;
}
