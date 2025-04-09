<?php

namespace App\Services\ManagementGroup;

use App\Models\ManagementGroup;
use App\Repositories\CustomerCategory\ICustomerCategoryRepository;
use App\Repositories\ManagementGroup\IManagementGroupRepository;

class ManagementGroupService implements IManagementGroupService
{
    public function __construct(
        public IManagementGroupRepository  $managementGroupRepository,
        public ICustomerCategoryRepository $customerCategoryRepository,
    )
    {
    }

    public function getRepo(): IManagementGroupRepository
    {
        return $this->managementGroupRepository;
    }

    public function getCustomerCategoryRepo(): ICustomerCategoryRepository
    {
        return $this->customerCategoryRepository;
    }

    public function getChildNames(ManagementGroup $managementGroup): ?string
    {
        $countRelation = $this->managementGroupRepository->checkRelations($managementGroup);
        if ($countRelation->social_events_count > 0) {
            return __('attributes.social_event.table');
        }
        return null;
    }
}

