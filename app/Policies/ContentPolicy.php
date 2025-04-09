<?php

namespace App\Policies;

use App\Enums\ScreenName\ContentNoEnum;
use App\Enums\ScreenName\ScreenCodeEnum;
use App\Trait\HasPermission;
use Illuminate\Auth\Access\Response;

class ContentPolicy extends BasePolicy
{
    use HasPermission;

    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
    }

    /**
     * Determine whether the user can update models.
     *
     * @return Response
     */
    public function update(): Response
    {
        $accessPermission = $this->getEmployeePermission();
        $screenContent = $this->getScreenContent(ScreenCodeEnum::SCREEN_CONTENT_EDIT, ContentNoEnum::getContentNo(ContentNoEnum::COMMON_REGISTRATION_CONTENTS, 'REGISTRATION'));
        return $this->checkPermission($screenContent, $accessPermission);
    }

    /**
     * Determine whether the user can update models.
     *
     * @return Response
     */
    public function delete(): Response
    {
        $accessPermission = $this->getEmployeePermission();
        $screenContent = $this->getScreenContent(ScreenCodeEnum::SCREEN_DISPLAY, ContentNoEnum::getContentNo(ContentNoEnum::SCREEN_DISPLAY_CONTENTS, 'CONTENT_DELETE'));
        return $this->checkPermission($screenContent, $accessPermission);
    }

    /**
     * Determine whether the user can update models.
     *
     * @return Response
     */
    public function store(): Response
    {
        $accessPermission = $this->getEmployeePermission();
        $screenContent = $this->getScreenContent(ScreenCodeEnum::SCREEN_CONTENT_ADD, ContentNoEnum::getContentNo(ContentNoEnum::COMMON_REGISTRATION_CONTENTS, 'REGISTRATION'));
        return $this->checkPermission($screenContent, $accessPermission);
    }
}
