<?php

namespace App\Broadcasting;

use App\Enums\System\SystemCodeEnum;
use App\Models\AccessPermission;
use App\Models\ChatThread;
use App\Models\Login;
use App\Repositories\AccessPermission\IAccessPermissionRepository;

class ChatThreadChannel
{
    /**
     * Create a new channel instance.
     */
    public function __construct(private IAccessPermissionRepository $accessPermissionRepository)
    {
        //
    }

    /**
     * Authenticate the user's access to the channel.
     */
    public function join(Login $user, ChatThread $chatThread): array|bool
    {
        $accessPermissions = $this->accessPermissionRepository->getSystemAccessiblePermission(SystemCodeEnum::SNET);
        $adminEmployeeIds = $accessPermissions->map(fn(AccessPermission $permission) => $permission->employee_id)->unique()->values();

        return $chatThread->creator_id == $user->employee_id || $adminEmployeeIds->contains($user->employee_id);
    }
}
