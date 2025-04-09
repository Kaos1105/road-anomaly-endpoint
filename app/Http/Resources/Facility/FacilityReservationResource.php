<?php

namespace App\Http\Resources\Facility;

use App\Http\DTO\Facility\ReservationCalendarItemData;
use App\Http\Resources\AttachmentFile\AttachmentFileResource;
use App\Http\Resources\Reservation\ReservationCalendarItemResource;
use App\Models\CompanyCalendar;
use App\Models\Facility;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;

/**
 * @mixin Facility
 */
class FacilityReservationResource extends JsonResource
{
    protected Collection $companyCalendars;
    protected array $facilityClassificationForCopy;

    public function setParams(Collection $companyCalendars, array $facilityClassificationForCopy): self
    {
        $this->companyCalendars = $companyCalendars;
        $this->facilityClassificationForCopy = $facilityClassificationForCopy;
        return $this;
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $avatar = $this->relationLoaded('attachmentFiles') ? $this->attachmentFiles->first() : null;
        $groupedReservation = $this->relationLoaded('reservations') ? $this->reservations->groupBy('reservation_date') : collect();
        $calendar = $groupedReservation->keys()->map(function (string $item) use (&$calendar, $groupedReservation) {
            $companyCalendar = $this->companyCalendars->first(function (CompanyCalendar $companyCalendar) use ($item) {
                return $item == $companyCalendar->date;
            });
            $reservations = $this->markDuplicated($groupedReservation[$item]);
            return ReservationCalendarItemData::mapFrom($companyCalendar, $reservations);
        });

        return [
            'id' => $this->id,
            'can_copy' => $this->facilityClassificationForCopy[$this->facility_classification] ?? false,
            'facility_group_id' => $this->facility_group_id,
            'name' => $this->name,
            'facility_classification' => $this->facility_classification,
            'use_classification' => $this->use_classification,
            'reservations_count' => $this->reservations_count,
            'avatar' => $avatar ? AttachmentFileResource::make($avatar, null)->toArray($request) : null,
            'calendar' => $calendar
        ];
    }

    public static function mapCollection(Collection $companyCalendars, Collection $facilities, array $facilityClassificationCanCopy): Collection
    {
        return collect($facilities)->map(fn($facility) => FacilityReservationResource::make($facility)->setParams($companyCalendars, $facilityClassificationCanCopy));
    }

    public function markDuplicated(Collection $reservationItems): Collection
    {
        return $reservationItems->map(function (Reservation $item) use ($reservationItems) {
            $overlapRecords = $reservationItems->filter(function (Reservation $comparingItem) use ($item) {
                return $item->end_time > $comparingItem->start_time && $item->start_time < $comparingItem->end_time;
            });
            $overlapRecords = $overlapRecords->sortBy(fn(Reservation $item) => $item->updated_at);
            $result = ReservationCalendarItemResource::make($item);
            if ($overlapRecords->count() === 1) {
                return $result;
            }
            /**
             * @var $first Reservation
             */
            $first = $overlapRecords->first();
            return $first->id == $item->id ? $result : $result->setParams(true);
        });
    }
}
