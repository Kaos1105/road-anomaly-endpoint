<?php

namespace App\Repositories\Reservation;

use App\Models\Facility;
use App\Models\Reservation;
use Illuminate\Database\Eloquent\Collection;
use Prettus\Repository\Contracts\RepositoryInterface;
use Spatie\QueryBuilder\QueryBuilder;

interface IReservationRepository extends RepositoryInterface
{
    public function findByQuery(QueryBuilder $query): Collection;

    public function getUserLatestReservation(int $facilityGroupId, int $facilityClassification): Reservation|null;
}

