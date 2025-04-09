<?php

namespace App\Services\CompanyCalendar;

use App\Models\CompanyCalendar;
use App\Repositories\CompanyCalendar\ICompanyCalendarRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use  Illuminate\Support\Collection as SupportCollection;

interface ICompanyCalendarService
{
    public function getRepo(): ICompanyCalendarRepository;

    public function getPaginateList(): LengthAwarePaginator;

    public function checkDate(): CompanyCalendar|null;

    public function getCalendarMonth(): Collection|null;

    public function upsertCompanyCalendar(int $companyId, SupportCollection $dataCollection): void;

    public function getCalendarYear(int $companyId, int $year = null): SupportCollection;

    public function getYear(mixed $validatedData): int;

    public function getFacilityCalendar(?int $holidayDisplay): SupportCollection;

}
