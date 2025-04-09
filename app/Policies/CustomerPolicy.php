<?php

namespace App\Policies;

use App\Enums\ScreenName\ContentNoEnum;
use App\Enums\ScreenName\ScreenCodeEnum;
use App\Trait\HasPermission;
use Illuminate\Auth\Access\Response;
use App\Enums\System\SystemCodeEnum;

class CustomerPolicy extends BasePolicy
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
        $accessPermission = $this->getEmployeePermission(SystemCodeEnum::SOCIAL);
        $screenContent = $this->getScreenContent(ScreenCodeEnum::CUSTOMER_ADD, ContentNoEnum::getContentNo(ContentNoEnum::COMMON_REGISTRATION_CONTENTS, 'REGISTRATION'));
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
        $screenContent = $this->getScreenContent(ScreenCodeEnum::COMPANY_EDIT, ContentNoEnum::getContentNo(ContentNoEnum::COMMON_REGISTRATION_CONTENTS, 'REGISTRATION'));
        return $this->checkPermission($screenContent, $accessPermission);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @return Response
     */
    public function delete(): Response
    {
        $accessPermission = $this->getEmployeePermission(SystemCodeEnum::SOCIAL);
        $screenContent = $this->getScreenContent(ScreenCodeEnum::CUSTOMER_DISPLAY, ContentNoEnum::getContentNo(ContentNoEnum::COMMON_DISPLAY_HEADER_CONTENTS, 'DELETE'));
        return $this->checkPermission($screenContent, $accessPermission);
    }

}
