<?php

namespace App\Repositories\Facility;

use App\Models\Facility;
use App\Models\FacilityGroup;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\RepositoryInterface;
use Spatie\QueryBuilder\QueryBuilder;

interface IFacilityRepository extends RepositoryInterface
{
    public function getPaginateList(): LengthAwarePaginator;

    public function findAll(FacilityGroup $facilityGroup): Collection|array;

    public function getDetail(Facility $facility): Model|QueryBuilder;

    public function getList(QueryBuilder $query, array $calendarDates): Collection;

    public function checkRelations(Facility $facility): Model|Facility;

    public function getFacilityReservationPortal(int $facilityGroupId): Collection;
}

