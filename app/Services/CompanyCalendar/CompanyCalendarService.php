<?php

namespace App\Services\CompanyCalendar;

use App\Enums\Common\DateTimeEnum;
use App\Enums\Facility\HolidayDisplayEnum;
use App\Enums\Schedule\CalendarClassificationEnum;
use App\Enums\Schedule\WorkClassificationEnum;
use App\Http\DTO\CompanyCalendar\CompanyCalendarData;
use App\Http\DTO\QueryParam\CompanyCalendarDashboardParam;
use App\Http\DTO\QueryParam\FacilityCompanyCalendarParam;
use App\Models\CompanyCalendar;
use App\Query\Schedule\CompanyCalendarQuery;
use App\Query\Schedule\FacilityCompanyCalendarQuery;
use App\Repositories\CompanyCalendar\ICompanyCalendarRepository;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection as SupportCollection;

class CompanyCalendarService implements ICompanyCalendarService
{
    public function __construct(
        public ICompanyCalendarRepository $companyCalendarRepository,
    )
    {
    }

    public function getRepo(): ICompanyCalendarRepository
    {
        return $this->companyCalendarRepository;
    }

    public function getPaginateList(): LengthAwarePaginator
    {
        return $this->companyCalendarRepository->getPaginateList();
    }

    public function checkDate(): CompanyCalendar|null
    {
        $filter = request('filter');
        if ($filter && $filter['date']) {
            $date = Carbon::parse($filter['date'])->format(DateTimeEnum::DATE_FORMAT_V2);
            return $this->companyCalendarRepository->checkDate($date);
        }
        return null;
    }

    public function getCalendarMonth(): Collection|null
    {
        $filter = request('filter');
        if ($filter['employee_id'] && $filter['date']) {
            $query = new CompanyCalendarQuery(new Request());
            return $this->companyCalendarRepository->getList($query->setCalendarFilterParam(new CompanyCalendarDashboardParam($filter['date'])));
        }
        return null;
    }

    /**
     * @throws \Throwable
     */
    public function upsertCompanyCalendar(int $companyId, SupportCollection $dataCollection): void
    {
        if ($dataCollection->count() === 0) {
            return;
        }
        DB::transaction(function () use ($dataCollection, $companyId) {
            /**
             * @var $first CompanyCalendarData
             */
            $first = $dataCollection->first();
            $this->companyCalendarRepository->deleteByCompanyCalendarByYear($companyId, Carbon::parse($first->date)->year);
            $companyCalendars = $dataCollection->map(function (CompanyCalendarData $item) use ($companyId) {
                $item->companyId = $companyId;
                return $item;
            });

            CompanyCalendar::insert($companyCalendars->toArray());
        });

    }

    public function getYear(mixed $validatedData): int
    {
        $firstCalendarItem = $validatedData['company_calendar'][0];
        return Carbon::parse($firstCalendarItem['date'])->year;
    }

    public function getCalendarYear(int $companyId, int $year = null): SupportCollection
    {
        $filter = request('filter');
        $requestedYear = $year ?? ($filter['year'] ?? null);
        if ($requestedYear) {
            return $this->companyCalendarRepository->getCompanyCalendarsByYear($companyId, $requestedYear);
        }
        return collect();
    }


    public function getFacilityCalendar(?int $holidayDisplay = HolidayDisplayEnum::DISPLAY): SupportCollection
    {
        $filter = request('filter');
        if ($filter['calendar_date']) {
            $query = new FacilityCompanyCalendarQuery(new Request());
            $companyCalendars = $this->companyCalendarRepository
                ->getList($query->setCalendarFilterParam(new FacilityCompanyCalendarParam($filter['calendar_date'])));

            return $this->fillCalendarDates($holidayDisplay, $companyCalendars, $filter['calendar_date']);
        }
        return collect();
    }

    private function fillCalendarDates(int $holidayDisplay, SupportCollection $companyCalendars, string $filterDate): SupportCollection
    {
        $startOfMonth = Carbon::parse($filterDate)->startOfMonth();
        $endOfMonth = Carbon::parse($filterDate)->endOfMonth();
        $missingDates = collect();
        $allDatesOfMonth = collect(CarbonPeriod::create($startOfMonth, $endOfMonth)->toArray())
            ->map(fn($date) => $date->toDateString());

        $allDatesOfMonth->each(function (string $date) use ($companyCalendars, $missingDates) {
            $isExisted = $companyCalendars->contains(function (CompanyCalendar $item) use ($date, $missingDates) {
                return $item->date === $date;
            });
            if (!$isExisted) {
                $missingDates->push(CompanyCalendar::make([
                    "date" => $date,
                    "calendar_classification" => CalendarClassificationEnum::WEEKDAY,
                    "calendar_contents" => null,
                    "work_classification" => WorkClassificationEnum::WORK_DAY,
                ]));
            }
        });

        $result = $missingDates->merge($companyCalendars);
        if ($holidayDisplay === HolidayDisplayEnum::NOT_DISPLAY) {
            $result = $result->filter(function (CompanyCalendar $item) use ($holidayDisplay) {
                $checkingDate = Carbon::parse($item->date);
                return $item->calendar_classification !== CalendarClassificationEnum::SUNDAY_HOLIDAY
                    && $item->calendar_classification !== CalendarClassificationEnum::NATIONAL_HOLIDAY;
//                    && $checkingDate->dayOfWeek !== 0;
            });
        }
        return $result->sortBy('date')->values();
    }


}
