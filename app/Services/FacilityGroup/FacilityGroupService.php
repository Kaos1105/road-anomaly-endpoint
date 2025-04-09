<?php

namespace App\Services\FacilityGroup;

use App\Models\FacilityGroup;
use App\Repositories\FacilityGroup\IFacilityGroupRepository;
use App\Trait\HasPermission;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\QueryBuilder;

readonly class FacilityGroupService implements IFacilityGroupService
{
    use  HasPermission;

    public function __construct(
        private IFacilityGroupRepository $facilityGroupRepository,
    )
    {
    }

    public function getRepo(): IFacilityGroupRepository
    {
        return $this->facilityGroupRepository;
    }

    public function createRecord(array $dataInsert): FacilityGroup
    {
        $facilityGroup = $this->facilityGroupRepository->create($dataInsert);

        return $facilityGroup->load(['createdBy', 'updatedBy', 'useGroup']);
    }

    public function getPaginateList(): LengthAwarePaginator
    {
        return $this->facilityGroupRepository->getPaginateList();
    }

    public function getChildNames(FacilityGroup $facilityGroup): ?string
    {
        $countRelation = $this->facilityGroupRepository->checkRelations($facilityGroup);

        if ($countRelation->facilities_count > 0) {
            return __('attributes.facility.table');
        }

        if ($countRelation->user_settings_count > 0) {
            return __('attributes.facility_user_setting.table');
        }
        return null;
    }

    public function findByQuery(QueryBuilder $query): Collection|array
    {
        return $this->facilityGroupRepository->findByQuery($query);
    }
}
