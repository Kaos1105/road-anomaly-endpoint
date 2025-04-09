<?php

namespace App\Policies;

use App\Enums\AccessPermission\Permission1FlagEnum;
use App\Models\AccessPermission;
use App\Models\Content;
use Illuminate\Auth\Access\Response;

class BasePolicy
{
    public function responsePolicy(bool $result = false): Response
    {
        return $result ? Response::allow() : Response::denyWithStatus(403, __('errors.forbidden'), 403);
    }

    public function checkPermission(Content $content = null, AccessPermission $accessPermission = null): Response
    {
//        $result = false;
//        if ($accessPermission && $content &&
//            $accessPermission->permission_1 != Permission1FlagEnum::UN_AUTHORIZED_USER &&
//            $accessPermission->permission_1 >= $content->permission_1 &&
//            $accessPermission->permission_2 >= $content->permission_2 &&
//            $accessPermission->permission_3 >= $content->permission_3 &&
//            $accessPermission->permission_4 >= $content->permission_4
//        ) {
//            $result = true;
//        }
        return $this->responsePolicy(true);
    }

    public function checkOnlyPermission1(Content $content = null, AccessPermission $accessPermission = null, int $accessPermission1 = Permission1FlagEnum::SYSTEM_MANAGER): Response
    {
//        $result = false;
//        if ($accessPermission && $content &&
//            $accessPermission->permission_1 >= $accessPermission1 &&
//            $accessPermission->permission_2 >= $content->permission_2 &&
//            $accessPermission->permission_3 >= $content->permission_3 &&
//            $accessPermission->permission_4 >= $content->permission_4
//        ) {
//            $result = true;
//        }
        return $this->responsePolicy(true);
    }
}
