<?php

namespace App\Policies;

use App\Enums\AccessPermission\Permission1FlagEnum;
use App\Enums\ScreenName\ContentNoEnum;
use App\Enums\ScreenName\ScreenCodeEnum;
use App\Models\Login;
use App\Trait\HandleErrorException;
use App\Trait\HasPermission;
use Illuminate\Auth\Access\Response;

class  AccessPermissionPolicy extends BasePolicy
{
    use HandleErrorException, HasPermission;

    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
    }

    /**
     * Determine whether the user can create models.
     *
     * @return Response
     */
    public function store(): Response
    {
        $accessPermission = $this->getEmployeePermission();
        $screenContent = $this->getScreenContent(ScreenCodeEnum::ACCESS_PERMISSION_ADD, ContentNoEnum::getContentNo(ContentNoEnum::COMMON_REGISTRATION_CONTENTS, 'REGISTRATION'));
        return $this->checkPermission($screenContent, $accessPermission);
    }


    public function updateEditablePermission(Login $login, ?int $systemId = null): Response
    {
        $result = false;
        $accessPermission = $this->getPermissionBySystemId($systemId);
        if ($accessPermission && $accessPermission->permission_1 == Permission1FlagEnum::SYSTEM_MANAGER) {
            $result = true;
        }
        return $this->responsePolicy($result);
    }
}
