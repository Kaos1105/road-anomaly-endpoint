<?php

namespace App\Services\ManagementGroup;

use App\Models\ManagementGroup;
use App\Repositories\CustomerCategory\ICustomerCategoryRepository;
use App\Repositories\ManagementGroup\IManagementGroupRepository;

interface IManagementGroupService
{
    public function getRepo(): IManagementGroupRepository;
    public function getCustomerCategoryRepo(): ICustomerCategoryRepository;

    public function getChildNames(ManagementGroup $managementGroup): ?string;

}
