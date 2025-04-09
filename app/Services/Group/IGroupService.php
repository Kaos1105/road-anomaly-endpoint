<?php

namespace App\Services\Group;

use App\Models\Group;
use App\Repositories\Group\IGroupRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface IGroupService
{
    public function getRepo(): IGroupRepository;

    public function createRecord(array $dataInsert): Group;

    public function getPaginateList(): LengthAwarePaginator;

    public function getGroupBothEmployeeAndUser(): Collection;

}
