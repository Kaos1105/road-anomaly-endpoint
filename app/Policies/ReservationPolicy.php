<?php

namespace App\Policies;

use App\Enums\AccessPermission\Permission1FlagEnum;
use App\Enums\ScreenName\ContentNoEnum;
use App\Enums\ScreenName\ScreenCodeEnum;
use App\Enums\System\SystemCodeEnum;
use App\Trait\HasPermission;
use Illuminate\Auth\Access\Response;

class ReservationPolicy extends BasePolicy
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
        $screenContent = $this->getScreenContent(ScreenCodeEnum::FACILITY_MANAGEMENT_DASHBOARD,
            ContentNoEnum::getContentNo(ContentNoEnum::FACILITY_MANAGEMENT_DASHBOARD, 'CALENDAR'));

        return $this->checkOnlyPermission1($screenContent, $accessPermission, Permission1FlagEnum::SYSTEM_USER);
    }

    /**
     * Determine whether the user can update models.
     *
     * @return Response
     */
    public function update(): Response
    {
        $accessPermission = $this->getEmployeePermission(SystemCodeEnum::FACILITY);
        $screenContent = $this->getScreenContent(ScreenCodeEnum::FACILITY_MANAGEMENT_DASHBOARD,
            ContentNoEnum::getContentNo(ContentNoEnum::FACILITY_MANAGEMENT_DASHBOARD, 'CALENDAR'));

        return $this->checkOnlyPermission1($screenContent, $accessPermission, Permission1FlagEnum::SYSTEM_USER);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @return Response
     */
    public function delete(): Response
    {
        $accessPermission = $this->getEmployeePermission(SystemCodeEnum::FACILITY);
        $screenContent = $this->getScreenContent(ScreenCodeEnum::FACILITY_MANAGEMENT_DASHBOARD,
            ContentNoEnum::getContentNo(ContentNoEnum::FACILITY_MANAGEMENT_DASHBOARD, 'CALENDAR'));

        return $this->checkOnlyPermission1($screenContent, $accessPermission, Permission1FlagEnum::SYSTEM_USER);
    }
}
