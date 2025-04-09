<?php

namespace App\Policies;

use App\Enums\ScreenName\ContentNoEnum;
use App\Enums\ScreenName\ScreenCodeEnum;
use App\Enums\System\SystemCodeEnum;
use App\Trait\HasPermission;
use Illuminate\Auth\Access\Response;

class SitePolicy extends BasePolicy
{
    use HasPermission;

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
        $accessPermission = $this->getEmployeePermission(SystemCodeEnum::ORGANIZATION);
        $screenContent = $this->getScreenContent(ScreenCodeEnum::SITE_ADD, ContentNoEnum::getContentNo(ContentNoEnum::COMMON_REGISTRATION_CONTENTS, 'REGISTRATION'));
        return $this->checkPermission($screenContent, $accessPermission);
    }

    /**
     * Determine whether the user can update models.
     *
     * @return Response
     */
    public function update(): Response
    {
        $accessPermission = $this->getEmployeePermission(SystemCodeEnum::ORGANIZATION);
        $screenContent = $this->getScreenContent(ScreenCodeEnum::SITE_EDIT, ContentNoEnum::getContentNo(ContentNoEnum::COMMON_REGISTRATION_CONTENTS, 'REGISTRATION'));
        return $this->checkPermission($screenContent, $accessPermission);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @return Response
     */
    public function delete(): Response
    {
        $accessPermission = $this->getEmployeePermission(SystemCodeEnum::ORGANIZATION);
        $screenContent = $this->getScreenContent(ScreenCodeEnum::SITE_DISPLAY, ContentNoEnum::getContentNo(ContentNoEnum::COMMON_DISPLAY_HEADER_CONTENTS, 'DELETE'));
        return $this->checkPermission($screenContent, $accessPermission);
    }

    /**
     * Determine whether the user can set represent the model.
     *
     * @return Response
     */
    public function setRepresentative(): Response
    {
        $accessPermission = $this->getEmployeePermission(SystemCodeEnum::ORGANIZATION);
        $screenContent = $this->getScreenContent(ScreenCodeEnum::SITE_DISPLAY, ContentNoEnum::getContentNo(ContentNoEnum::SITE_DISPLAY_CONTENTS, 'DEPARTMENT_REPRESENTATIVE'));
        return $this->checkPermission($screenContent, $accessPermission);
    }

}
