<?php

namespace App\Http\Controllers\Facility;

use App\Http\Controllers\Controller;
use App\Http\DTO\ResponseData;
use App\Http\Resources\Group\GroupDropdownResource;
use App\Services\Group\IGroupService;

class MainGroupController extends Controller
{
    public function __construct(
        private readonly IGroupService $groupService,
    )
    {
    }

    public function dropdownGroup(): ResponseData
    {
        $result = $this->groupService->getRepo()->getGroupsInUse();
        return $this->httpOk(GroupDropdownResource::collection($result));
    }

}
