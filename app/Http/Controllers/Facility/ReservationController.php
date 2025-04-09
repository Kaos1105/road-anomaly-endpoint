<?php

namespace App\Http\Controllers\Facility;

use App\Http\Controllers\Controller;
use App\Http\DTO\Facility\ReservationCalendarData;
use App\Http\DTO\ResponseData;
use App\Http\Requests\Reservation\CopyReservationRequest;
use App\Http\Requests\Reservation\UpsertReservationRequest;
use App\Http\Resources\CompanyCalendar\CompanyCalendarItemResource;
use App\Http\Resources\Facility\FacilityReservationResource;
use App\Http\Resources\Reservation\ReservationCalendarResource;
use App\Models\Facility;
use App\Models\Reservation;
use App\Services\CompanyCalendar\ICompanyCalendarService;
use App\Services\Facility\IFacilityService;
use App\Services\FacilityUserSetting\IFacilityUserSettingService;
use App\Services\Reservation\IReservationService;

class ReservationController extends Controller
{
    public function __construct(
        private readonly IReservationService         $reservationService,
        private readonly IFacilityService            $facilityService,
        private readonly ICompanyCalendarService     $companyCalendarService,
        private readonly IFacilityUserSettingService $facilityUserSettingService,
    )
    {
    }

    public function index(): ResponseData
    {
        $facilityClassificationForCopy = $this->reservationService->checkFacilityClassificationForCopying();
        $userSetting = $this->facilityUserSettingService->showUserSetting();
        $companyCalendars = $this->companyCalendarService->getFacilityCalendar($userSetting->holiday_display);
        $facilities = $this->facilityService->getCalendarMonth($companyCalendars);

        $result = FacilityReservationResource::mapCollection($companyCalendars, $facilities, $facilityClassificationForCopy);
        $companyCalendarsResource = CompanyCalendarItemResource::collection($companyCalendars)->collection;

        return $this->httpOk(new ReservationCalendarData($companyCalendarsResource, $result));
    }

    public function store(UpsertReservationRequest $request): ResponseData
    {
        $data = $request->validated();
        $result = $this->reservationService->createRecord($data);

        return $this->httpCreated(new ReservationCalendarResource($result));
    }

    public function update(UpsertReservationRequest $request, Reservation $reservation): ResponseData
    {
        $data = $request->validated();
        $result = $this->reservationService->updateRecord($data, $reservation);

        return $this->httpCreated(new ReservationCalendarResource($result));
    }

    public function copy(CopyReservationRequest $request, Facility $facility): ResponseData
    {
        $data = $request->validated();
        $result = $this->reservationService->getCopyDetail($data, $facility);

        return $this->httpOk(new ReservationCalendarResource($result));
    }

    public function destroy(Reservation $reservation): ResponseData
    {
        $this->reservationService->getRepo()->delete($reservation->id);

        return $this->httpNoContent();
    }
}
