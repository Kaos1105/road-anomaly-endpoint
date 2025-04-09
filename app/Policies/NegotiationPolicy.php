<?php

namespace App\Policies;

use App\Enums\ScreenName\ContentNoEnum;
use App\Enums\ScreenName\ScreenCodeEnum;
use App\Enums\System\SystemCodeEnum;
use App\Trait\HasPermission;
use Illuminate\Auth\Access\Response;

class NegotiationPolicy extends BasePolicy
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
        $accessPermission = $this->getEmployeePermission(SystemCodeEnum::NEGOTIATION);
        $screenContent = $this->getScreenContent(ScreenCodeEnum::NEGOTIATION_HISTORY_ADD, ContentNoEnum::getContentNo(ContentNoEnum::COMMON_REGISTRATION_CONTENTS, 'REGISTRATION'));
        return $this->checkPermission($screenContent, $accessPermission);
    }

    /**
     * Determine whether the user can update models.
     *
     * @return Response
     */
    public function update(): Response
    {
        $accessPermission = $this->getEmployeePermission(SystemCodeEnum::NEGOTIATION);
        $screenContent = $this->getScreenContent(ScreenCodeEnum::NEGOTIATION_HISTORY_EDIT, ContentNoEnum::getContentNo(ContentNoEnum::COMMON_REGISTRATION_CONTENTS, 'REGISTRATION'));
        return $this->checkPermission($screenContent, $accessPermission);
    }

    /**
     * Determine whether the user can comment negotiation.
     *
     * @return Response
     */
    public function comment(): Response
    {
        $accessPermission = $this->getEmployeePermission(SystemCodeEnum::NEGOTIATION);
        $screenContent = $this->getScreenContent(ScreenCodeEnum::NEGOTIATION_HISTORY_MANAGEMENT_COMMENT, ContentNoEnum::getContentNo(ContentNoEnum::COMMON_REGISTRATION_CONTENTS, 'REGISTRATION'));
        return $this->checkPermission($screenContent, $accessPermission);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @return Response
     */
    public function delete(): Response
    {
        $accessPermission = $this->getEmployeePermission(SystemCodeEnum::NEGOTIATION);
        $screenContent = $this->getScreenContent(ScreenCodeEnum::NEGOTIATION_HISTORY_DISPLAY, ContentNoEnum::getContentNo(ContentNoEnum::COMMON_DISPLAY_HEADER_CONTENTS, 'DELETE'));
        return $this->checkPermission($screenContent, $accessPermission);
    }

}
