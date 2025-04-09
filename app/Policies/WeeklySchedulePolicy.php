<?php

namespace App\Policies;

use App\Enums\ScreenName\ContentNoEnum;
use App\Enums\ScreenName\ScreenCodeEnum;
use App\Enums\System\SystemCodeEnum;
use App\Trait\HasPermission;
use Illuminate\Auth\Access\Response;

class WeeklySchedulePolicy extends BasePolicy
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
        return $this->checkPermission();
    }

    /**
     * Determine whether the user can update models.
     *
     * @return Response
     */
    public function update(): Response
    {
        return $this->checkPermission();
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @return Response
     */
    public function delete(): Response
    {
        return $this->checkPermission();
    }

}
