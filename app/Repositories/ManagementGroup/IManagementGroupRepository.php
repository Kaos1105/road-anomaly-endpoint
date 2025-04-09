<?php

namespace App\Repositories\ManagementGroup;

use App\Models\ManagementGroup;
use App\Query\ManagementGroup\ManagementGroupDropdownQuery;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\RepositoryInterface;

interface IManagementGroupRepository extends RepositoryInterface
{
    public function showDetail(ManagementGroup $detail): ManagementGroup;

    public function getList(): Collection;

    public function createManagementGroup(array $attributes): ManagementGroup|Model|null;

    public function updateManagementGroup(array $attributes, ManagementGroup $managementGroup): ManagementGroup|Model|null;

    public function dropdownCustomerCategory(): Collection|array|null;

    public function findByQuery(ManagementGroupDropdownQuery $query): Collection|array;

    public function checkRelations(ManagementGroup $employee): Model|ManagementGroup;

    public function getDashboardList(): Collection;

    public function numberOfRecordInUse(): int;
}
