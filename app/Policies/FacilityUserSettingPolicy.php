<?php

namespace App\Policies;

use App\Enums\ScreenName\ContentNoEnum;
use App\Enums\ScreenName\ScreenCodeEnum;
use App\Enums\System\SystemCodeEnum;
use App\Trait\HasPermission;
use Illuminate\Auth\Access\Response;

class FacilityUserSettingPolicy extends BasePolicy
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
     * @return Response
     */
    public function store(): Response
    {
        $accessPermission = $this->getEmployeePermission(SystemCodeEnum::FACILITY);
        $screenContent = $this->getScreenContent(ScreenCodeEnum::FACILITY_USER_SETTING, ContentNoEnum::getContentNo(ContentNoEnum::COMMON_REGISTRATION_CONTENTS, 'BASIC_INFORMATION'));
        return $this->checkPermission($screenContent, $accessPermission);
    }

}
