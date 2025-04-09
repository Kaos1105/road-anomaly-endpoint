<?php

namespace App\Repositories\FacilityGroup;

use App\Models\FacilityGroup;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\RepositoryInterface;
use Spatie\QueryBuilder\QueryBuilder;

interface IFacilityGroupRepository extends RepositoryInterface
{
    public function getPaginateList(): LengthAwarePaginator;

    public function findAll(): Collection|array;

    public function getDetail(FacilityGroup $facilityGroup): Model|QueryBuilder;

    public function checkRelations(FacilityGroup $facilityGroup): Model|FacilityGroup|null;

    public function findByQuery(QueryBuilder $query): Collection;

    public function countPortalData(): int;

    public function dropdownFacilityGroupUserSetting(): Collection|array;

}

