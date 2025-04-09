<?php

namespace App\Services\Reservation;

use App\Enums\Facility\FacilityClassificationEnum;
use App\Enums\Schedule\PublicClassificationEnum;
use App\Models\Facility;
use App\Models\Reservation;
use App\Models\TimeSchedule;
use App\Repositories\Reservation\IReservationRepository;
use DB;
use Illuminate\Support\Collection;
use Throwable;

readonly class ReservationService implements IReservationService
{
    public function __construct(
        private IReservationRepository $reservationRepository,
    )
    {
    }

    public function getRepo(): IReservationRepository
    {
        return $this->reservationRepository;
    }

    /**
     * @throws Throwable
     */
    public function createRecord(array $dataInsert): Reservation
    {
        $result = null;
        DB::transaction(function () use ($dataInsert, &$result) {
            $reservation = Reservation::create($dataInsert);
            if ($dataInsert['regis_time_schedule']) {
                TimeSchedule::create([
                    ...$dataInsert,
                    'employee_id' => $reservation->use_person_id,
                    'date' => $reservation->reservation_date,
                    'work_place' => $reservation?->facility?->name,
                    'public_classification' => PublicClassificationEnum::ALL_MEMBER
                ]);
            }
            $result = $reservation->load(['createdBy', 'updatedBy', 'usePerson']);
        });
        return $result;
    }

    public function updateRecord(array $dataUpdate, Reservation $reservation): Reservation
    {
        $result = $this->getRepo()->update($dataUpdate, $reservation->id);

        return $result->load(['createdBy', 'updatedBy', 'usePerson']);
    }


    public function getCopyDetail(array $copyData, Facility $facility): Reservation
    {
        $latestReservation = $this->getRepo()->getUserLatestReservation($facility->facility_group_id, $facility->facility_classification);
        $reservation = Reservation::make([
            'facility_id' => $facility->id,
            'reservation_date' => $copyData['reservation_date'],
            'start_time' => $latestReservation?->start_time,
            'end_time' => $latestReservation?->end_time,
            'work_contents' => $latestReservation?->work_contents,
            'use_person_id' => $latestReservation?->use_person_id,
        ]);
        return $reservation->load(['usePerson']);
    }

    public function checkFacilityClassificationForCopying(): array|null
    {
        $filter = request('filter');
        $filerGroupId = $filter['facility_group_id'];
        if (empty($filter['facility_group_id'])) {
            return null;
        }

        $result = [];
        collect(FacilityClassificationEnum::getValues())->each(function (int $classification) use (&$result, $filerGroupId) {
            $reservation = $this->getRepo()->getUserLatestReservation($filerGroupId, $classification);
            $result[$classification] = !!$reservation;
        });

        return $result;
    }
}
