<?php

namespace App\Http\Controllers\Schedule;

use App\Http\Controllers\Controller;
use App\Http\DTO\ResponseData;
use App\Http\Resources\Group\GroupDropdownResource;
use App\Services\Group\IGroupService;

class GroupController extends Controller
{
    public function __construct(
        private readonly IGroupService $groupService,
    )
    {
    }

    public function dropdownGroup(): ResponseData
    {
        $result = $this->groupService->getGroupBothEmployeeAndUser();
        return $this->httpOk(GroupDropdownResource::collection($result));
    }

}
