<?php

namespace App\Broadcasting;

use App\Enums\System\SystemCodeEnum;
use App\Models\AccessPermission;
use App\Models\Login;
use App\Repositories\AccessPermission\IAccessPermissionRepository;

class AdminThreadsChannel
{
    /**
     * Create a new channel instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Authenticate the user's access to the channel.
     */
    public function join(Login $user, int $adminEmployeeId): array|bool
    {
        return $user->employee_id == $adminEmployeeId;
    }
}
