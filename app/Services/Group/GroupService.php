<?php

namespace App\Services\Group;

use App\Enums\AccessPermission\Permission1FlagEnum;
use App\Enums\Common\UseFlagEnum;
use App\Enums\System\SystemCodeEnum;
use App\Models\Group;
use App\Repositories\Group\IGroupRepository;
use App\Trait\HasPermission;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

readonly class GroupService implements IGroupService
{
    use  HasPermission;

    public function __construct(
        private IGroupRepository $groupRepository,
    )
    {
    }

    public function getRepo(): IGroupRepository
    {
        return $this->groupRepository;
    }

    public function createRecord(array $dataInsert): Group
    {
        $group = $this->groupRepository->create($dataInsert);
        $employeeIds = $dataInsert['employee_ids'];
        $result = [];
        foreach ($employeeIds as $id) {
            $result[] = ['employee_id' => $id];
        }
        $group->groupEmployees()->createMany($result);
        return $group->load(['createdBy', 'updatedBy', 'employees']);
    }

    public function getPaginateList(): LengthAwarePaginator
    {
        $request = request();
        $accessPermission = $this->getEmployeePermission(SystemCodeEnum::MAIN);
        if ($accessPermission->permission_1 == Permission1FlagEnum::SYSTEM_MANAGER) {
            $request['sort'] = 'admin';
        } else {
            $request['sort'] = 'user';
            $request['filter'] = $request['filter']
                ? [...$request['filter'], 'employee_id' => \Auth::user()->employee_id]
                : ['employee_id' => \Auth::user()->employee_id];
        }
        return $this->groupRepository->getPaginateList();
    }

    public function getGroupBothEmployeeAndUser(): Collection
    {
        $request = request();
        $defaultFilter = [
            'user_id' => \Auth::user()->employee_id,
            'use_classification' => UseFlagEnum::USE
        ];
        $request['filter'] = $request['filter']
            ? [...$request['filter'], ...$defaultFilter]
            : $defaultFilter;
        return $this->groupRepository->getGroupBothEmployeeAndUser();
    }
}
