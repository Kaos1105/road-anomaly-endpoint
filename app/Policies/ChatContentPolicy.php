<?php

namespace App\Policies;

use App\Enums\ScreenName\ContentNoEnum;
use App\Enums\ScreenName\ScreenCodeEnum;
use App\Enums\System\SystemCodeEnum;
use App\Models\ChatThread;
use App\Models\Login;
use App\Trait\HasPermission;
use Illuminate\Auth\Access\Response;

class ChatContentPolicy extends BasePolicy
{
    use  HasPermission;

    /**
     * Create a new policy instance.
     */
    public function __construct()
    {

    }

    /**
     * Determine whether the user can create models.
     *
     * @param Login $user
     * @param string|null $chatThreadId
     * @return Response
     */
    public function store(Login $user, string|null $chatThreadId): Response
    {
        return $this->responsePolicy(true);
    }

}
