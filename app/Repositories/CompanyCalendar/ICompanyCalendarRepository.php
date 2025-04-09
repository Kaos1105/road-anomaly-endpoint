<?php

namespace App\Repositories\CompanyCalendar;

use App\Models\CompanyCalendar;
use App\Query\Schedule\CompanyCalendarQuery;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Prettus\Repository\Contracts\RepositoryInterface;
use Spatie\QueryBuilder\QueryBuilder;

interface ICompanyCalendarRepository extends RepositoryInterface
{
    public function getDetail(CompanyCalendar $detail): CompanyCalendar;

    public function getPaginateList(): LengthAwarePaginator;

    public function checkDate(string $date): CompanyCalendar|null;

    public function getList(QueryBuilder $query): Collection;

    public function getCompanyCalendarsByYear(int $companyId, int $year): Collection;

    public function countCompanyCalendarDuringPeriod(int $companyId, string $startDate, string $endDate): int;

}
