<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Http\DTO\ResponseData;
use App\Http\Requests\Group\UpsertGroupRequest;
use App\Http\Resources\Group\GroupCollection;
use App\Http\Resources\Group\GroupDetailResource;
use App\Models\Group;
use App\Services\Group\IGroupService;

class GroupController extends Controller
{
    public function __construct(
        private readonly IGroupService $groupService,
    )
    {
    }

    public function index(): ResponseData
    {
        $result = $this->groupService->getPaginateList();
        return $this->httpOk(new GroupCollection($result));
    }

    public function store(UpsertGroupRequest $request): ResponseData
    {
        $data = $request->validated();
        $group = $this->groupService->createRecord($data);
        return $this->httpCreated(GroupDetailResource::make($group));
    }

    public function show(Group $group): ResponseData
    {
        $result = $this->groupService->getRepo()->getDetail($group);
        return $this->httpOk(new GroupDetailResource($result));
    }

    public function update(UpsertGroupRequest $request, Group $group): ResponseData
    {
        $data = $request->validated();
        $group = $this->groupService->getRepo()->update($data, $group->id);
        $result = $this->groupService->getRepo()->getDetail($group);
        return $this->httpOk(new GroupDetailResource($result));
    }

}
