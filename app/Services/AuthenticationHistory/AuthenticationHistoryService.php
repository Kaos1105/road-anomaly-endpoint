<?php

namespace App\Services\AuthenticationHistory;

use App\Enums\AuthenticationHistory\SummaryTableEnum;
use App\Enums\Common\DateTimeEnum;
use App\Enums\Common\PaginationEnum;
use App\Http\DTO\AuthenticationHistory\AuthenticationHistorySummaryData;
use App\Http\DTO\AuthenticationHistory\MonthData;
use App\Http\DTO\AuthenticationHistory\SummaryData;
use App\Http\DTO\AuthenticationHistory\YearData;
use App\Repositories\AuthenticationHistory\IAuthenticationHistoryRepository;
use App\Trait\HasPermission;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class AuthenticationHistoryService implements IAuthenticationHistoryService
{
    use HasPermission;

    public function __construct(
        public IAuthenticationHistoryRepository $authenticationHistoryRepository,
    )
    {
    }

    public function getRepo(): IAuthenticationHistoryRepository
    {
        return $this->authenticationHistoryRepository;
    }

    public function getListYears(): array
    {
        $currentYear = Carbon::now()->year;
        $history = $this->authenticationHistoryRepository->getLastHistory();

        $firstYear = $history && $history->authen_at
            ? Carbon::parse($history->authen_at)->year
            : $currentYear;

        return range($firstYear, $currentYear);
    }

    public function getSummary(): SummaryData|null
    {
        $filter = request('filter');
        if (!$filter || empty($filter['year'])) {
            return null;
        }
        $years = [(int)$filter['year'], $filter['year'] - SummaryTableEnum::LAST_YEAR_KEY, $filter['year'] - SummaryTableEnum::TWO_YEAR_AGO_KEY];

        $monthData = $this->authenticationHistoryRepository->countActionEachMonthByYear($filter['year']);
        $yearData = $this->authenticationHistoryRepository->countActionByYears($years);

        $monthly = collect();
        foreach (DateTimeEnum::SHORT_NAME_MONTHS_OF_YEAR as $month) {
            $monthly->push(new MonthData($month));
        }
        $listYears = collect();
        foreach ($years as $year) {
            $listYears->push(new YearData($year));
        }
        $result = AuthenticationHistorySummaryData::mapCollection($listYears, $monthly, $yearData, $monthData);

        return new SummaryData($years, $result);
    }

    public function getHistoryCard(): Collection|null
    {
        $numberRecord = request('records') ?? PaginationEnum::NUMBER_RECORD_DASHBOARD_10;
        return $this->authenticationHistoryRepository->findTopicDashboard($numberRecord);
    }
}
