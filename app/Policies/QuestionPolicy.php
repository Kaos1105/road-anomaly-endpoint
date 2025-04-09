<?php

namespace App\Policies;

use App\Enums\ScreenName\ContentNoEnum;
use App\Enums\ScreenName\ScreenCodeEnum;
use App\Enums\System\SystemCodeEnum;
use App\Trait\HasPermission;
use Illuminate\Auth\Access\Response;

class QuestionPolicy extends BasePolicy
{
    use HasPermission;

    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
    }

    /**
     * Determine whether the user can store/update models.
     *
     * @return Response
     */
    public function store(): Response
    {
        $accessPermission = $this->getEmployeePermission();
        $screenContent = $this->getScreenContent(ScreenCodeEnum::HELP_FAQ_DISPLAY, ContentNoEnum::getContentNo(ContentNoEnum::COMMON_DISPLAY_HEADER_CONTENTS, 'EDIT'));
        return $this->checkPermission($screenContent, $accessPermission);
    }

    /**
     * Determine whether the user can update models.
     *
     * @return Response
     */
    public function update(): Response
    {
        $accessPermission = $this->getEmployeePermission(SystemCodeEnum::SOCIAL);
        $screenContent = $this->getScreenContent(ScreenCodeEnum::PRODUCT_EDIT, ContentNoEnum::getContentNo(ContentNoEnum::COMMON_REGISTRATION_CONTENTS, 'REGISTRATION'));
        return $this->checkPermission($screenContent, $accessPermission);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @return Response
     */
    public function delete(): Response
    {
        $accessPermission = $this->getEmployeePermission();
        $screenContent = $this->getScreenContent(ScreenCodeEnum::HELP_FAQ_DISPLAY, ContentNoEnum::getContentNo(ContentNoEnum::COMMON_DISPLAY_HEADER_CONTENTS, 'DELETE'));
        return $this->checkPermission($screenContent, $accessPermission);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @return Response
     */
    public function answer(): Response
    {
        $accessPermission = $this->getEmployeePermission();
        $screenContent = $this->getScreenContent(ScreenCodeEnum::HELP_FAQ_EDIT, ContentNoEnum::getContentNo(ContentNoEnum::HELP_FAQ_EDIT_CONTENTS, 'ANSWER'));
        return $this->checkPermission($screenContent, $accessPermission);
    }
}
