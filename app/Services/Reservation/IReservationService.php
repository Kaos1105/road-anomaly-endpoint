<?php

namespace App\Services\Reservation;

use App\Models\Facility;
use App\Models\Reservation;
use App\Repositories\Reservation\IReservationRepository;
use Illuminate\Support\Collection;

interface IReservationService
{
    public function getRepo(): IReservationRepository;

    public function createRecord(array $dataInsert): Reservation|null;

    public function updateRecord(array $dataUpdate, Reservation $reservation): Reservation;

    public function getCopyDetail(array $copyData, Facility $facility): Reservation;

    public function checkFacilityClassificationForCopying(): array|null;

}
