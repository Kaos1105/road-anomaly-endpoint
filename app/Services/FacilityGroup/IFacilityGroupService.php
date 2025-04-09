<?php

namespace App\Services\FacilityGroup;

use App\Models\FacilityGroup;
use App\Repositories\FacilityGroup\IFacilityGroupRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\QueryBuilder;

interface IFacilityGroupService
{
    public function getRepo(): IFacilityGroupRepository;

    public function createRecord(array $dataInsert): FacilityGroup;

    public function getPaginateList(): LengthAwarePaginator;

    public function getChildNames(FacilityGroup $facilityGroup): ?string;

    public function findByQuery(QueryBuilder $query): Collection|array;

}
