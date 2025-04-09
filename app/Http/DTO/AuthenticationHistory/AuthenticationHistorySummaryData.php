<?php

declare(strict_types=1);

namespace App\Http\DTO\AuthenticationHistory;

use App\Enums\AuthenticationHistory\AuthenticationActionEnum;
use App\Enums\AuthenticationHistory\SummaryTableEnum;
use Illuminate\Support\Collection;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapInputName(SnakeCaseMapper::class)]
#[MapOutputName(SnakeCaseMapper::class)]
class AuthenticationHistorySummaryData extends Data
{
    public function __construct(
        public ?string       $action = null,
        public ?ItemCellData $summary = null,
    )
    {

    }

    public static function mapCollection(Collection $years, Collection $months, ?Collection $yearAuthHistories, ?Collection $monthAuthHistories): Collection
    {
        // Each action
        $result = collect();
        $monthActions = $monthAuthHistories?->groupBy('action');
        $yearActions = $yearAuthHistories?->groupBy('action');

        foreach (AuthenticationActionEnum::getValues() as $action) {
            $monthData = $monthActions?->get($action);
            $yearData = $yearActions?->get($action);

            $monthCollection = $months;
            if ($monthData) {
                $monthData = MonthData::mapCollection($monthData);
                $monthCollection = $monthData->merge($months)->unique('month');
            }

            $monthlyCount = [];
            $monthCollection->each(function (MonthData $item) use (&$monthlyCount) {
                $monthlyCount[$item->month] = $item->actionCount;
            });

            if ($yearData) {
                $years = collect($yearData)->merge($years)->unique('year')->sortByDesc('year');
            }
            $yearCollection = $years;
            $yearsCount = self::getYearSummary($yearCollection);

            $result->push(new AuthenticationHistorySummaryData(
                $action,
                ItemCellData::from([...$monthlyCount, ...$yearsCount])));
        }

        // Total
        $monthTotal = $monthAuthHistories?->groupBy('month')?->map(function ($group, $month) {
            return new MonthData($month, $group->sum('action_count'));
        })?->values();

        $totalCollection = $months;

        if ($monthTotal->count() > 0) {
            $totalCollection = $monthTotal->merge($months)->unique('month')->values();
        }

        $monthTotal = [];
        $totalCollection->each(function (MonthData $item) use (&$monthTotal) {
            $monthTotal[$item->month] = $item->actionCount;
        });


        $yearTotal = $yearAuthHistories?->groupBy('year')?->map(function ($group, $year) {
            return new YearData($year, $group->sum('action_count'));
        })?->values();

        $yearCollection = $years;
        if ($yearTotal) {
            $yearCollection = collect($yearTotal)->merge($years)->unique('year')->sortByDesc('year');
        }

        $yearsCount = self::getYearSummary($yearCollection);
        $result->push(new AuthenticationHistorySummaryData(
            null,
            ItemCellData::from([...$monthTotal, ...$yearsCount])));

        return $result;
    }

    private static function getYearSummary(Collection $yearCollection): array
    {
        $year = YearData::from($yearCollection->get(SummaryTableEnum::YEAR_KEY));
        $lastYear = YearData::from($yearCollection->get(SummaryTableEnum::LAST_YEAR_KEY));
        $twoYearAgo = YearData::from($yearCollection->get(SummaryTableEnum::TWO_YEAR_AGO_KEY));

        return [
            'year' => $year->actionCount,
            'last_year' => $lastYear->actionCount,
            'two_year_ago' => $twoYearAgo->actionCount,
        ];
    }
}
