<?php

namespace App\Repositories\CompanyCalendar;

use App\Models\CompanyCalendar;
use App\Query\Schedule\CompanyCalendarQuery;
use App\Trait\HasFavorite;
use App\Trait\HasPagination;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Prettus\Repository\Eloquent\BaseRepository;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class CompanyCalendarRepository extends BaseRepository implements ICompanyCalendarRepository
{
    use HasPagination, HasFavorite;

    public function model(): string
    {
        return CompanyCalendar::class;
    }

    protected string $defaultSort = 'date';

    protected array $allowedFilters = [];

    protected function allowedExactFilters(): array
    {
        return [
            AllowedFilter::exact('id'),
            AllowedFilter::exact('calendar_classification'),
        ];
    }

    protected function allowedScopedFilters(): array
    {
        return [];
    }

    protected function allowedCustomFilters(): array
    {
        return [];
    }

    protected array $allowedSorts = [
        'id',
        'date'
    ];

    protected function allowedCustomSorts(): array
    {
        return [];
    }

    protected array $allowedIncludes = [
    ];

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        //$this->pushCriteria(app(RequestCriteria::class));
    }

    protected function filters(): QueryBuilder
    {
        return QueryBuilder::for($this->model())
            ->allowedFilters([
                ...$this->allowedFilters,
                ...$this->allowedExactFilters(),
                ...$this->allowedScopedFilters(),
                ...$this->allowedCustomFilters(),
            ])
            ->allowedIncludes($this->allowedIncludes)
            ->allowedSorts([
                ...$this->allowedSorts,
                ...$this->allowedCustomSorts(),
            ])
            ->defaultSort($this->defaultSort)
            ->addSelect(CompanyCalendar::$selectProps);
    }

    public function getDetail(CompanyCalendar $detail): CompanyCalendar
    {
        return $detail->load(['company']);
    }

    public function getPaginateList(): LengthAwarePaginator
    {
        return $this->filters()->paginate($this->getPerPage());
    }


    public function checkDate(string $date): CompanyCalendar|null
    {
        return CompanyCalendar::where('date', $date)->first();
    }

    public function getList(QueryBuilder $query): Collection
    {
        return $query->defaultSort($this->defaultSort)
            ->addSelect(CompanyCalendar::$selectProps)
            ->get();
    }


    public function deleteByCompanyCalendarByYear(int $companyId, int $year): int
    {
        return CompanyCalendar::where('company_id', $companyId)
            ->whereYear('date', $year)->delete();
    }

    public function getCompanyCalendarsByYear(int $companyId, int $year): Collection
    {
        return CompanyCalendar::where('company_id', $companyId)
            ->whereYear('date', $year)
            ->orderBy('date')
            ->get();
    }

    public function countCompanyCalendarDuringPeriod(int $companyId, string $startDate, string $endDate): int
    {
        return CompanyCalendar::where('company_id', $companyId)
            ->whereBetween('date', [$startDate, $endDate])
            ->orderBy('date')
            ->count();
    }
}
