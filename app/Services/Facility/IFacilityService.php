<?php

namespace App\Services\Facility;

use App\Models\Facility;
use App\Models\FacilityGroup;
use App\Repositories\Facility\IFacilityRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection as SupportCollection;

interface IFacilityService
{
    public function getRepo(): IFacilityRepository;

    public function createRecord(array $dataInsert): Facility;

    public function getPaginateList(): LengthAwarePaginator;

    public function getChildNames(Facility $facility): ?string;

    public function deleteRecord(Facility $facility): void;

    public function getCalendarMonth(SupportCollection $companyCalendar): SupportCollection;
}
